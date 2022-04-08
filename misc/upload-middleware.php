<?php

class DocxConversion{
    private $filename;

    public function __construct($filePath) {
        $this->filename = $filePath;
    }

    private function read_doc() {
        $fileHandle = fopen($this->filename, "r");
        $line = @fread($fileHandle, filesize($this->filename));   
        $lines = explode(chr(0x0D),$line);
        $outtext = "";
        foreach($lines as $thisline)
          {
            $pos = strpos($thisline, chr(0x00));
            if (($pos !== FALSE)||(strlen($thisline)==0))
              {
              } else {
                $outtext .= $thisline." ";
              }
          }
         $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
        return $outtext;
    }

    private function read_docx(){

        $striped_content = '';
        $content = '';

        $zip = zip_open($this->filename);

        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

            if (zip_entry_name($zip_entry) != "word/document.xml") continue;

            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }// end while

        zip_close($zip);

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);

        return $striped_content;
    }

    public function convertToText() {

        if(isset($this->filename) && !file_exists($this->filename)) {
            return "File Not exists";
        }

        $fileArray = pathinfo($this->filename);
        $file_ext  = $fileArray['extension'];
        if($file_ext == "doc" || $file_ext == "docx")
        {
            if($file_ext == "doc") {
                return $this->read_doc();
            } elseif($file_ext == "docx") {
                return $this->read_docx();
            }
        } else {
            return "Invalid File Type";
        }
    }
}

add_filter( "wp_handle_upload", "zhm_process_uploaded_file", 10, 2 );

function zhm_process_uploaded_file($upload, $context) {
    $text_extensions = array("doc", "docx", "txt");
    $file_url = $upload['file'];
    
    $extension = end(explode(".", $file_url));

    if (in_array($extension, $text_extensions)) {
        $docObj = new DocxConversion($file_url);

        $text = $docObj->convertToText();

        wp_insert_post(
            array(
                'post_title' => $upload['url'],
                'post_content' => $text,
                'meta_input' => array(
                    'zhm_related_file_url' => $upload['url']
                ),
                'post_type' => 'zhm_doc',
                'post_status' => 'publish'
            )
        );
    }

    return $upload;
}



function zhm_on_attachment_delete($id) {
    $url = wp_get_attachment_url($id);

    $posts = get_posts(array(
        'post_type' => 'zhm_doc',
        'meta_query' => array(
            array(
                'key' => 'zhm_related_file_url',
                'value' => $url,
                'compare' => '=',
            )
        )
    ));

    if ($posts && $posts[0]) {
        wp_delete_post( $posts[0]->ID, true );
    }
}

add_action( 'delete_attachment', 'zhm_on_attachment_delete', 10, 1);

?>