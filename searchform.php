<div itemscope itemtype="https://schema.org/WebSite">
  <link itemprop="url" href="<?php echo esc_url(home_url('/')); ?>"/>
  <form
    itemprop="potentialAction"
    itemscope
    itemtype="https://schema.org/SearchAction"
    role="search"
    action="<?php echo esc_url(home_url('/')); ?>"
    method="get"
    class="d-flex justify-content-end search-form"
  >
    <meta itemprop="target" content="<?php echo esc_url(home_url('/') . "?s={query}"); ?>"/>
    <input
      type="text"
      placeholder="Пошук"
      aria-label="Пошук"
      value="<?php the_search_query(); ?>"
      name="s"
      itemprop="query"
      class="me-md-2 bold primary-font full-width"
    >
    <button
      type="submit"
      class="search-button primary-font bold"
    >
      Шукати
    </button>
  </form>
</div>