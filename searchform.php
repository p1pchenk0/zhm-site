<form
  role="search"
  action="<?php echo esc_url(home_url('/')); ?>"
  method="get"
  class="d-flex justify-content-end search-form"
>
  <input
    type="text"
    placeholder="Пошук"
    aria-label="Пошук"
    value="<?php the_search_query(); ?>"
    name="s"
    class="me-md-2 bold primary-font"
  >
  <button
    type="submit"
    class="search-button primary-font bold"
  >
    Шукати
  </button>
</form>
