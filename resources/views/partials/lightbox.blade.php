{{-- Lightbox overlay --}}
<div class="lightbox" id="lightbox" aria-hidden="true">
    <div class="lightbox-backdrop" data-lightbox-close></div>
    <button class="lightbox-btn lightbox-prev" type="button" data-lightbox-prev aria-label="Previous image">
        <i data-lucide="chevron-left" aria-hidden="true"></i>
    </button>
    <figure class="lightbox-stage">
        <img class="lightbox-img skeleton" src="" alt="">
        <figcaption class="lightbox-caption">
            <div class="lightbox-caption-text">
                <b></b>
                <span></span>
            </div>
            <div class="lightbox-actions">
                <a class="btn btn-ghost btn-sm lightbox-download" href="#" title="Download">
                    <i data-lucide="download" aria-hidden="true"></i>
                </a>
                <form class="lightbox-fav-form" action="#" method="POST">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-ghost btn-sm btn-icon" type="submit" title="Favorite">
                        <i data-lucide="star" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </figcaption>
    </figure>
    <button class="lightbox-btn lightbox-next" type="button" data-lightbox-next aria-label="Next image">
        <i data-lucide="chevron-right" aria-hidden="true"></i>
    </button>
    <button class="lightbox-btn lightbox-close" type="button" data-lightbox-close aria-label="Close">
        <i data-lucide="x" aria-hidden="true"></i>
    </button>
</div>
