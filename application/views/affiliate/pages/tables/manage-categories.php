

    <div class="page-wrapper">
    <!-- Content Header (Page header) -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Explore Product Categories</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Categories</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE HEADER -->

    <div class="page-body">
        <div class="container-xl">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <?php if (!empty($affiliate_categories)) { ?>
                        <div class="row g-3">
                            <?php foreach ($affiliate_categories as $index => $affiliate_category) { ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <a href="<?= base_url('affiliate/product/get_categories_products/' . $affiliate_category['id']) ?>" 
                                       class="category-card d-block text-decoration-none position-relative" 
                                       style="animation: fadeInScale 0.6s ease-out forwards; animation-delay: <?= $index * 0.15 ?>s; opacity: 0;">
                                        <div class="card border-0 rounded-3 overflow-hidden" style="height: 220px;">
                                            <img src="<?= base_url($affiliate_category['image']) ?>" 
                                                 alt="<?= htmlspecialchars($affiliate_category['name']) ?>" 
                                                 class="w-100 h-100 object-fit-cover" 
                                                 style="transition: transform 0.3s ease;">
                                            <div class="card-img-overlay d-flex flex-column justify-content-end p-3" 
                                                 style="background: linear-gradient(to bottom, rgba(0,0,0,0) 40%, rgba(0,0,0,0.8) 100%);">
                                                <h4 class="card-title text-white mb-1 category-title"><?= htmlspecialchars($affiliate_category['name']) ?></h4>
                                                <div class="d-flex align-items-center text-white">
                                                    <small class="fw-medium">Shop Now</small>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-right ms-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M5 12h14" />
                                                        <path d="M15 16l4 -4" />
                                                        <path d="M15 8l4 4" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="empty text-center p-5">
                            <div class="empty-img mb-4">
                                <img src="./static/illustrations/undraw_empty_cart_co35.svg" height="128" alt="No categories">
                            </div>
                            <h3 class="empty-title mb-2">No Categories Available</h3>
                            <p class="empty-subtitle text-muted mb-4">
                                It looks like there are no affiliate categories to display right now.
                            </p>
                            <div class="empty-action">
                                <a href="<?= base_url('affiliate/home') ?>" class="btn btn-outline-dark px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                    </svg>
                                    Back to Home
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
.category-card:hover img {
    transform: scale(1.05);
}
.category-card:hover {
    transform: translateY(-3px);
    transition: transform 0.3s ease;
}
</style>

<script>
    $(document).ready(function() {
        $('.category-card').on('click', function() {
            const categoryName = $(this).find('.category-title').text() || 'Special Category';
            console.log('Category clicked:', categoryName);
        });
    });
</script>