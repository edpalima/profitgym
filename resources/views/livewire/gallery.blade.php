<div class="gallery-section">
    <div class="gallery">
        <div class="grid-sizer"></div>
        
        @foreach($galleries as $gallery)
            <div class="gs-item set-bg" data-setbg="{{ asset('storage/' . $gallery->image) }}">
                <a href="{{ asset('storage/' . $gallery->image) }}" class="thumb-icon image-popup">
                    <i class="fa fa-picture-o"></i>
                </a>
            </div>
        @endforeach
    </div>
</div>