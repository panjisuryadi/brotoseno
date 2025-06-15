<!-- php artisan make:component library/Datatable -->
{{-- <x-library.widget /> --}}
{{-- <iframe src="https://harga-emas.org/widget/widget.php?v_widget_type=current_gold_price&v_height=300"></iframe> --}}

{{--
<a href="mailto:test@test.com" data-toggle="popover" title="Popover" data-content="test content <a href='#' title='test add link'>link on content</a>" data-original-title="test title">Test</a>
 --}}

@push('page_css')

<style type="text/css">

</style>

@endpush

@push('page_scripts')

<script type="text/javascript">
$(document).ready(function() {
  $('[data-toggle="popover"]').popover({
    placement: 'top',
    html: true
  });

  $('[data-toggle="popover"]').on("mouseenter", function() {
    $(this).popover('show');
  });

  $('body').on('click', function(e) {
    $('[data-toggle=popover]').each(function() {
      if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
        $(this).popover('hide');
      }
    });
  });
});
</script>

@endpush
