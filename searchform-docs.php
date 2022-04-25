<?php

$file_type = isset($_GET['file_type']) ? $_GET['file_type'] : null;
$doc_accept_date_from = isset($_GET['doc_accept_date_from']) ? $_GET['doc_accept_date_from'] : null;
$doc_accept_date_to = isset($_GET['doc_accept_date_to']) ? $_GET['doc_accept_date_to'] : null;
$doc_publish_date_from = isset($_GET['doc_publish_date_from']) ? $_GET['doc_publish_date_from'] : null;
$doc_publish_date_to = isset($_GET['doc_publish_date_to']) ? $_GET['doc_publish_date_to'] : null;
$s = isset($_GET['s']) ? $_GET['s'] : null;

?>

<form class="search-form file-search text-primary secondary-font" action="<?php echo home_url( '/' ); ?>">
    <input type="search" name="s" placeholder="Пошук" class="full-width mb-3 text-primary" value="<?php echo $s; ?>">
    <br>
    <input type="hidden" name="type" value="document">

    <select name="file_type" class="full-width mb-3 text-primary">
        <option value="all">
            Тип документа
        </option>
    <?php
        $types = zhm_get_doc_types();

        foreach($types as $type) {
    ?>
        <option value="<?php echo $type['id']; ?>" <?php selected( $file_type, $type['id'] ); ?>>
            <?php echo $type['label']; ?>
        </option>
    <?php } ?>
    </select>
    
    <div class="date-fields mb-3">
        <div class="mb-2">Дата прийняття документа:</div>
        <div class="d-flex justify-content-between align-items-center">
            <span>з</span><input name="doc_accept_date_from" class="text-primary" value="<?php echo $doc_accept_date_from ?: ''; ?>"/>
            <span>до</span><input name="doc_accept_date_to" class="text-primary" value="<?php echo $doc_accept_date_to ?: ''; ?>"/>
        </div>
    </div>

    <div class="date-fields mb-3">
        <div class="mb-2">Дата публікації документа:</div>
        <div class="d-flex justify-content-between align-items-center">
            <span>з</span><input name="doc_publish_date_from" class="text-primary" value="<?php echo $doc_publish_date_from ?: ''; ?>"/>
            <span>до</span><input name="doc_publish_date_to" class="text-primary" value="<?php echo $doc_publish_date_to ?: ''; ?>"/>
        </div>
    </div>

    <input type="submit" value="Шукати" class="full-width text-primary bold">
</form>


<script type="text/javascript">
  jQuery(document).ready(function($) {
    var datepickerOptions = {
        dateFormat : 'yy-mm-dd',
        prevText: 'Назад',
        beforeShow: function(input, inst){
            $(inst.dpDiv).addClass('datepicker-visible');
        },
        onClose: function(dateText, inst) {
            $(inst.dpDiv).removeClass('datepicker-visible');
        }
    };

    var datepickerAcceptFrom = 'input[name="doc_accept_date_from"]';
    var datepickerAcceptTo = 'input[name="doc_accept_date_to"]';
    var datepickerPublishFrom = 'input[name="doc_publish_date_from"]';
    var datepickerPublishTo = 'input[name="doc_publish_date_to"]';

    $(datepickerAcceptFrom).datepicker(datepickerOptions);
    $(datepickerAcceptTo).datepicker(datepickerOptions);
    $(datepickerPublishFrom).datepicker(datepickerOptions);
    $(datepickerPublishTo).datepicker(datepickerOptions);

    $(datepickerAcceptFrom).datepicker('option', 'onSelect', function(selectedDate) {
        var acceptFromDate = $(datepickerAcceptFrom).datepicker("getDate");
        var acceptToDate = $(datepickerAcceptTo).datepicker("getDate");
        
        if (!acceptToDate) return;

        if (acceptFromDate.getTime() > acceptToDate.getTime()) {
            $(datepickerAcceptTo).datepicker("setDate", null);
        }
    });

    $(datepickerAcceptTo).datepicker('option', 'onSelect', function(selectedDate) {
        var acceptFromDate = $(datepickerAcceptFrom).datepicker("getDate");
        var acceptToDate = $(datepickerAcceptTo).datepicker("getDate");
        
        if (!acceptFromDate) return;

        if (acceptFromDate.getTime() > acceptToDate.getTime()) {
            $(datepickerAcceptFrom).datepicker("setDate", null);
        }
    });

    $(datepickerPublishFrom).datepicker('option', 'onSelect', function(selectedDate) {
        var publishFromDate = $(datepickerPublishFrom).datepicker("getDate");
        var publishToDate = $(datepickerPublishTo).datepicker("getDate");
        
        if (!publishToDate) return;

        if (publishFromDate.getTime() > publishToDate.getTime()) {
            $(datepickerPublishTo).datepicker("setDate", null);
        }
    });

    $(datepickerPublishTo).datepicker('option', 'onSelect', function(selectedDate) {
        var publishFromDate = $(datepickerPublishFrom).datepicker("getDate");
        var publishToDate = $(datepickerPublishTo).datepicker("getDate");
        
        if (!publishFromDate) return;

        if (publishFromDate.getTime() > publishToDate.getTime()) {
            $(datepickerPublishFrom).datepicker("setDate", null);
        }
    });
  });       
</script>