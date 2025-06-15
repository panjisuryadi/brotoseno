<div class="p-0 object-center">
<?php

    $image = $data->images;
    $imagePath = empty($image)?url('images/fallback_product_image.png'):asset(imageUrl().$image);

?>
<a href="{{ $imagePath }}" data-lightbox="{{ @$image }} " class="single_image">
    <img src="{{ $imagePath }}" order="0" width="175" class="img-thumbnail"/>
</a>
 </div>