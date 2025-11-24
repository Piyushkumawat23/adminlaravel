@extends('frontend.layouts.app')

@section('content')
    <aside id="notifications">
    </aside>

    <section id="wrapper">
        <div class="container-fluid">
            <div class="row">

                <nav data-depth="1" class="breadcrumb col-xs-12">
                    <ol itemscope itemtype="http://schema.org/BreadcrumbList">
                        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                            <a itemprop="item" href="">
                                <span itemprop="name">Home</span>
                            </a>
                            <meta itemprop="position" content="1">
                        </li>
                    </ol>
                </nav>

                <div id="cat-left-column"></div>

                <div id="content-wrapper" class="col-xs-12">
                    <section id="main">
                        <section id="content" class="page-home">
                            <div class="s-panel">
                                <div class="loader wrloader"></div>
                                <div class="homeslider-container slideshow-panel" data-interval="5000"
                                    data-wrap="true" data-pause="hover">
                                    <ul class="slider slider-for">
                                        <li class="slide slide-flex row">
                                            <div class="slidecap col-xs-6">
                                                <div class="slidedes">
                                                    <h3>Best Artist Paintings</h3>
                                                    <h2>Latest Painting Collection</h2>
                                                    <p>Discover the world through original paintings for sale</p>
                                                    <span class="slidehref"><a
                                                            href="#"
                                                            class="btn btn-primary">shop now</a></span>
                                                </div>
                                            </div>
                                            <div class="slideimg col-xs-6">
                                                <a
                                                    href="#">
                                                    <img src="https://prestashop.dostguru.com/ART01/artista_01/modules/wbimageslider/views/img/slider-1.jpg"
                                                        alt="slider-1" class="img-responsive center-block" width=960
                                                        height=950 />
                                                </a>
                                            </div>
                                        </li>
                                        <li class="slide slide-flex row">
                                            <div class="slidecap col-xs-6">
                                                <div class="slidedes">
                                                    <h3>Best Artist Paintings</h3>
                                                    <h2>Latest Painting Collection</h2>
                                                    <p>Discover the world through original paintings for sale</p>
                                                    <span class="slidehref"><a
                                                            href="#"
                                                            class="btn btn-primary">shop now</a></span>
                                                </div>
                                            </div>
                                            <div class="slideimg col-xs-6">
                                                <a
                                                    href="#">
                                                    <img src="https://prestashop.dostguru.com/ART01/artista_01/modules/wbimageslider/views/img/slider-2.jpg"
                                                        alt="slider-2" class="img-responsive center-block" width=960
                                                        height=950 />
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="offerb">
                                <div class="container">
                                    <div data-wrap="true">
                                        <div class="row">
                                            <div class="offerbimg col-sm-6 col-xs-12">
                                                <div class="beffect">
                                                    <a
                                                        href="#">
                                                        <img src="https://prestashop.dostguru.com/ART01/artista_01/modules/wbimgoffer/views/img/offerbanner-1.jpg"
                                                            alt="offerbanner-1" width=675 height=600
                                                            class="img-responsive center-block" />
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="offerbdesc col-sm-6 col-xs-12">
                                                <h5>About</h5>
                                                <h2>Helenarts</h2>
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                                    industry. Lorem Ipsum has been the industrys standard dummy text
                                                    ever since the 1500s, when an unknown printer took a galley of
                                                    type and
                                                    scrambled it to make a type specimen book. It has survived not
                                                    only five centuries, but also the leap into electronic
                                                    typesetting, remaining essentially unchanged.</p>
                                                <span class="off-sign"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-tab-item">
                                <div class="container">
                                    <div class="pro-tab tabs">
                                        <h2 class="heading text-xs-center"><span>Trending product</span></h2>
                                        <ul class="list-inline nav nav-tabs text-xs-center">
                                            <li class="nav-item"><a class="nav-link active" href="#tab-fea-0"
                                                    data-toggle="tab">featured</a>
                                            </li>
                                            <li class="nav-item"><a class="nav-link" href="#tab-new-0"
                                                    data-toggle="tab">latest</a>
                                            </li>
                                            <li class="nav-item"><a class="nav-link" href="#tab-best-0"
                                                    data-toggle="tab">bestseller</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content tab-pro container" id="tab-content">
                                    <section id="tab-fea-0" class="tab-pane fadeIn in active clearfix animated">
                                        <div class="products row rless">
                                            <div id="owl-fea" class="owl-carousel owl-theme">
                                                <ul>
                                                    <li>
                                                        <article
                                                            class="product-miniature js-product-miniature col-xs-12 cless"
                                                            data-id-product="1" data-id-product-attribute="1"
                                                            itemscope itemtype="http://schema.org/Product">
                                                            <div class="thumbnail-container">
                                                                <div class="thumbrel">
                                                                    <div class="wb-image-block">
                                                                        <a href="#"
                                                                            class="thumbnail product-thumbnail">
                                                                            <img class="center-block img-responsive"
                                                                                src="https://prestashop.dostguru.com/ART01/artista_01/93-home_default/hummingbird-printed-t-shirt.jpg"
                                                                                alt="Hummingbird printed t-shirt"
                                                                                data-full-size-image-url="https://prestashop.dostguru.com/ART01/artista_01/93-large_default/hummingbird-printed-t-shirt.jpg"
                                                                                width="360" height="463">
                                                                            <img class="second-img img-responsive center-block"
                                                                                src="https://prestashop.dostguru.com/ART01/artista_01/93-home_default/hummingbird-printed-t-shirt.jpg"
                                                                                alt="" title="" itemprop="image"
                                                                                width="360" height="463">
                                                                        </a>
                                                                        <ul class="product-flags">
                                                                            <li class="product-flag discount">
                                                                                <span>-20%</span>
                                                                            </li>
                                                                            <li class="product-flag new">
                                                                                <span>New</span>
                                                                            </li>
                                                                        </ul>
                                                                        <div class="sale"><span>-20%</span></div>
                                                                        <div
                                                                            class="comments_note wb-list-product-reviews">
                                                                            <div class="star_content clearfix">
                                                                                <span class="avg-rate">
                                                                                    <span
                                                                                        class="rate-tot">5</span><i
                                                                                        class="fa fa-star emstar"></i>
                                                                                    <span class="or-rate">
                                                                                        <span class="fa fa-stack"><i
                                                                                                class="fa fa-star fa-stack-2x"></i><i
                                                                                                class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                        <span class="fa fa-stack"><i
                                                                                                class="fa fa-star fa-stack-2x"></i><i
                                                                                                class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                        <span class="fa fa-stack"><i
                                                                                                class="fa fa-star fa-stack-2x"></i><i
                                                                                                class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                        <span class="fa fa-stack"><i
                                                                                                class="fa fa-star fa-stack-2x"></i><i
                                                                                                class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                        <span class="fa fa-stack"><i
                                                                                                class="fa fa-star fa-stack-2x"></i><i
                                                                                                class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                    </span>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="wb-product-desc text-left">
                                                                        <h3 class="h3 product-title"
                                                                            itemprop="name"><a
                                                                                href="#">Hummingbird
                                                                                printed t-shirt</a></h3>
                                                                        <div id="product-description-short-1"
                                                                            itemprop="description" class="listds">
                                                                            <p>Fusce ornare laoreet euismod. Duis
                                                                                sollicitudin sit amet massa vel
                                                                                bibendum. Quisque convallis sapien
                                                                                ut felis euismod, nec pharetra
                                                                                tortor vulputate. Ut fringilla orci
                                                                                ut
                                                                                augue aliquet, vitae volutpat enim
                                                                                interdum. Morbi efficitur tellus
                                                                                risus, sed faucibus mi varius eget.
                                                                                Sed pharetra, enim sit amet rhoncus
                                                                                consectetur, dui ex placerat
                                                                                dolor</p>
                                                                        </div>
                                                                        <div
                                                                            class="product-price-and-shipping pricehv">
                                                                            <span itemprop="price"
                                                                                class="price">$19.12</span>
                                                                            <span class="sr-only">Regular
                                                                                price</span>
                                                                            <span
                                                                                class="regular-price">$23.90</span>
                                                                            <span class="sr-only">Price</span>
                                                                        </div>
                                                                        <div class="button-group">
                                                                            <div class="add-to-cart-product">
                                                                                <form
                                                                                    action="#"
                                                                                    method="post">
                                                                                    <input type="hidden"
                                                                                        name="token"
                                                                                        value="eb5ddc2cc7bec12cfea5360306257b98">
                                                                                    <input type="hidden"
                                                                                        name="id_product" value="1">
                                                                                    <button
                                                                                        class="add-to-cart cartb"
                                                                                        data-button-action="add-to-cart"
                                                                                        type="submit">
                                                                                        <svg width="17px"
                                                                                            height="17px" class="">
                                                                                            <use
                                                                                                xlink:href="#pcart" />
                                                                                        </svg>
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                            <a class="quick-view quick" href="#"
                                                                                data-link-action="quickview"
                                                                                title="Quickview">
                                                                                <svg width="20px" height="19px">
                                                                                    <use xlink:href="#bquick" />
                                                                                </svg>
                                                                            </a>
                                                                            <button data-toggle="tooltip"
                                                                                title="Wishlist" class="wish"
                                                                                id="wishlist_button"
                                                                                onclick="WishlistCart('wishlist_block_list', 'add', '1', 1, 1); return false;"><svg
                                                                                    width="20px" height="19px">
                                                                                    <use xlink:href="#heart"></use>
                                                                                </svg></button>
                                                                            <div class="compare">
                                                                                <a class="add_to_compare title_font btn-product wb-compare-button"
                                                                                    href="#" data-id-product="1"
                                                                                    title="Add to Compare">
                                                                                    <svg width="20px" height="19px">
                                                                                        <use xlink:href="#compare">
                                                                                        </use>
                                                                                    </svg><span>compare</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </article>
                                                        <article
                                                            class="product-miniature js-product-miniature col-xs-12 cless"
                                                            data-id-product="2" data-id-product-attribute="9"
                                                            itemscope itemtype="http://schema.org/Product">
                                                            <div class="thumbnail-container">
                                                                <div class="thumbrel">
                                                                    <div class="wb-image-block">
                                                                        <a href="#"
                                                                            class="thumbnail product-thumbnail">
                                                                            <img class="center-block img-responsive"
                                                                                src="https://prestashop.dostguru.com/ART01/artista_01/91-home_default/brown-bear-printed-sweater.jpg"
                                                                                alt="Hummingbird printed sweater"
                                                                                data-full-size-image-url="https://prestashop.dostguru.com/ART01/artista_01/91-large_default/brown-bear-printed-sweater.jpg"
                                                                                width="360" height="463">
                                                                            <img class="second-img img-responsive center-block"
                                                                                src="https://prestashop.dostguru.com/ART01/artista_01/92-home_default/brown-bear-printed-sweater.jpg"
                                                                                alt="" title="" itemprop="image"
                                                                                width="360" height="463">
                                                                        </a>
                                                                        <ul class="product-flags">
                                                                            <li class="product-flag discount">
                                                                                <span>-20%</span>
                                                                            </li>
                                                                            <li class="product-flag new">
                                                                                <span>New</span>
                                                                            </li>
                                                                        </ul>
                                                                        <div class="sale"><span>-20%</span></div>
                                                                        <div
                                                                            class="comments_note wb-list-product-reviews">
                                                                            <div class="star_content clearfix">
                                                                                <span class="avg-rate">
                                                                                    <span
                                                                                        class="rate-tot">3</span><i
                                                                                        class="fa fa-star emstar"></i>
                                                                                    <span class="or-rate">
                                                                                        <span class="fa fa-stack"><i
                                                                                                class="fa fa-star fa-stack-2x"></i><i
                                                                                                class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                        <span class="fa fa-stack"><i
                                                                                                class="fa fa-star fa-stack-2x"></i><i
                                                                                                class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                        <span class="fa fa-stack"><i
                                                                                                class="fa fa-star fa-stack-2x"></i><i
                                                                                                class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                        <span class="fa fa-stack"><i
                                                                                                class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                        <span class="fa fa-stack"><i
                                                                                                class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                    </span>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="wb-product-desc text-left">
                                                                        <h3 class="h3 product-title"
                                                                            itemprop="name"><a
                                                                                href="#">Hummingbird
                                                                                printed sweater</a></h3>
                                                                        <div id="product-description-short-2"
                                                                            item itemprop="description" class="listds">
                                                                            <p>Fusce ornare laoreet euismod. Duis
                                                                                sollicitudin sit amet massa vel
                                                                                bibendum. Quisque convallis sapien
                                                                                ut felis euismod, nec pharetra
                                                                                tortor vulputate. Ut fringilla orci
                                                                                ut
                                                                                augue aliquet, vitae volutpat enim
                                                                                interdum. Morbi efficitur tellus
                                                                                risus, sed faucibus mi varius eget.
                                                                                Sed pharetra, enim sit amet rhoncus
                                                                                consectetur, dui ex placerat
                                                                                dolor</p>
                                                                        </div>
                                                                        <div
                                                                            class="product-price-and-shipping pricehv">
                                                                            <span itemprop="price"
                                                                                class="price">$28.72</span>
                                                                            <span class="sr-only">Regular
                                                                                price</span>
                                                                            <span
                                                                                class="regular-price">$35.90</span>
                                                                            <span class="sr-only">Price</span>
                                                                        </div>
                                                                        <div class="button-group">
                                                                            <div class="add-to-cart-product">
                                                                                <form
                                                                                    action="#"
                                                                                    method="post">
                                                                                    <input type="hidden"
                                                                                        name="token"
                                                                                        value="eb5ddc2cc7bec12cfea5360306257b98">
                                                                                    <input type="hidden"
                                                                                        name="id_product" value="2">
                                                                                    <button
                                                                                        class="add-to-cart cartb"
                                                                                        data-button-action="add-to-cart"
                                                                                        type="submit">
                                                                                        <svg width="17px"
                                                                                            height="17px" class="">
                                                                                            <use
                                                                                                xlink:href="#pcart" />
                                                                                        </svg>
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                            <a class="quick-view quick" href="#"
                                                                                data-link-action="quickview"
                                                                                title="Quickview">
                                                                                <svg width="20px" height="19px">
                                                                                    <use xlink:href="#bquick" />
                                                                                </svg>
                                                                            </a>
                                                                            <button data-toggle="tooltip"
                                                                                title="Wishlist" class="wish"
                                                                                id="wishlist_button"
                                                                                onclick="WishlistCart('wishlist_block_list', 'add', '2', 9, 1); return false;"><svg
                                                                                    width="20px" height="19px">
                                                                                    <use xlink:href="#heart"></use>
                                                                                </svg></button>
                                                                            <div class="compare">
                                                                                <a class="add_to_compare title_font btn-product wb-compare-button"
                                                                                    href="#" data-id-product="2"
                                                                                    title="Add to Compare">
                                                                                    <svg width="20px" height="19px">
                                                                                        <use xlink:href="#compare">
                                                                                        </use>
                                                                                    </svg><span>compare</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    </li>
                                                    
                                                   
                                                </ul>
                                            </div>
                                        </div>
                                    </section>
                                    <section id="tab-new-0" class="tab-pane clearfix fadeIn animated">
                                    </section>
                                    <section id="tab-best-0" class="tab-pane clearfix fadeIn animated">
                                    </section>
                                </div>
                            </div>

                            <div class="imgbanner">
                                <div class="banner-bg-offer">
                                    <div data-wrap="true">
                                        <div class="row">
                                            <div class="offer-flex">
                                                <div class="col-sm-5 col-xs-12 off-ca">
                                                    <div class="offer-banner-caption">
                                                        <h2>our latest collection of</h2>
                                                        <h2>original <span>Artworks &amp; Paintings</span></h2>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7 col-xs-12 off-img">
                                                    <div class="beffect">
                                                        <a
                                                            href="#">
                                                            <img src="https://prestashop.dostguru.com/ART01/artista_01/modules/wbimgbanner/views/img/banner-1.jpg"
                                                                alt="banner-1" width=1163 height=725
                                                                class="img-responsive center-block" />
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <section class="featured-products">
                                    <h2 class="heading text-xs-center"><span>Special</span></h2>
                                    <div class="products row rless">
                                        <div id="owl-spe" class="owl-carousel owl-theme">
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <div class="cate-bg">
                                <div class="container text-xs-center">
                                    <div class="wb_category_feature wberCategoryFeature homecategory row cate-row">
                                        <div class="col-lg-5 col-md-4 col-sm-3 col-xs-12">
                                            <div class="heading">
                                                <h1 class="text-xs-left">
                                                    <span>top categories</span>
                                                </h1>
                                                <h3 class="text-xs-left">Discover the world through original
                                                    paintings for sale</h3>
                                            </div>
                                        </div>
                                        <div class="category_feature col-lg-7 col-md-8 col-sm-9 col-xs-12">
                                            <div class="wbCategoryFeature row marginrow next-prevb">
                                                <div id="owl-catfeaturee">
                                                    <div class="col-sm-4 col-xs-12 propaddingcat-pa first-cate">
                                                        <div class="item">
                                                            <a href="#"
                                                                title="Tools">
                                                                <div class="cat-img ">
                                                                    <div class="cate-img">
                                                                        <div class="cate-img-bg">
                                                                            <img src="https://prestashop.dostguru.com/ART01/artista_01/img/c/3.jpg"
                                                                                class="img-responsive center-block" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="content-cate">
                                                                        <h2 class="categoryName">
                                                                            <span>Tools</span>
                                                                        </h2>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-xs-12 cat-pa propadding middle-cate ">
                                                        <div class="item">
                                                            <a href="#"
                                                                title="Accessories">
                                                                <div class="cat-img ">
                                                                    <div class="cate-img">
                                                                        <div class="cate-img-bg">
                                                                            <img src="https://prestashop.dostguru.com/ART01/artista_01/img/c/6.jpg"
                                                                                class="img-responsive center-block" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="content-cate">
                                                                        <h2 class="categoryName">
                                                                            <span>Accessories</span>
                                                                        </h2>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="item">
                                                            <a href="#"
                                                                title="Stationery">
                                                                <div class="cat-img ">
                                                                    <div class="cate-img">
                                                                        <div class="cate-img-bg">
                                                                            <img src="https://prestashop.dostguru.com/ART01/artista_01/img/c/7.jpg"
                                                                                class="img-responsive center-block" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="content-cate">
                                                                        <h2 class="categoryName">
                                                                            <span>Stationery</span>
                                                                        </h2>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-xs-12 cat-pa propadding last-cate">
                                                        <div class="item">
                                                            <a href="#"
                                                                title="Art">
                                                                <div class="cat-img ">
                                                                    <div class="cate-img">
                                                                        <div class="cate-img-bg">
                                                                            <img src="https://prestashop.dostguru.com/ART01/artista_01/img/c/9.jpg"
                                                                                class="img-responsive center-block" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="content-cate">
                                                                        <h2 class="categoryName">
                                                                            <span>Art</span>
                                                                        </h2>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="item">
                                                            <a href="#"
                                                                title="Paint">
                                                                <div class="cat-img ">
                                                                    <div class="cate-img">
                                                                        <div class="cate-img-bg">
                                                                            <img src="https://prestashop.dostguru.com/ART01/artista_01/img/c/10.jpg"
                                                                                class="img-responsive center-block" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="content-cate">
                                                                        <h2 class="categoryName">
                                                                            <span>Paint</span>
                                                                        </h2>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="wbhblog">
                                <div class="container home_blog_post_area general displayHome">
                                    <h2 class="heading text-xs-center"><span>News</span></h2>
                                    <div class="home_blog_post row rless">
                                        <div class="home_blog_post_inner carousel">
                                            <div id="blog" class="home_blog_post_inner owl-carousel owl-theme">
                                                <article class="blog_post col-xs-12 cless">
                                                    <div class="blog_post_content">
                                                        <div class="blog_post_content_top">
                                                            <div class="post_thumbnail">
                                                                <img class="wbblog_img img-responsive"
                                                                    src="/ART01/artista_01/modules/wbblog/views/img/home_blog-2.jpg"
                                                                    alt="This is Secound Post For wbBlog">
                                                                <div class="blog_mask content">
                                                                    <div class="blog_mask_content">
                                                                        <a class="thumbnail_lightbox icon"
                                                                            href="/ART01/artista_01/modules/wbblog/views/img/large-2.jpg"
                                                                            data-lightbox="example-set">
                                                                            <i class="material-icons">zoom_in</i>
                                                                        </a>
                                                                        <a href="#"
                                                                            class="icon"><i
                                                                                class="material-icons">shuffle</i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="blogdt date-time">
                                                                    <h3 class="blogda">10</h3>
                                                                    <h3 class="blogmo">Feb</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="blog_post_content_bottom text-xs-left">
                                                            <h3 class="post_title"><a
                                                                    href="#">This
                                                                    is Secound Post For wbBlog</a></h3>
                                                            <div class="post_content">
                                                                <p>Lorem Ipsum is simply dummy text of the printing
                                                                    and typesetting industry. Lorem Ipsum has been
                                                                    the industrys standard dummy text ever since the
                                                                    1500s, when an ...</p>
                                                            </div>
                                                            <a class="read_more btn btn-primary"
                                                                href="#">Read
                                                                More</a>
                                                        </div>
                                                    </div>
                                                </article>
                                                <article class="blog_post col-xs-12 cless">
                                                    <div class="blog_post_content">
                                                        <div class="blog_post_content_top">
                                                            <div class="post_thumbnail">
                                                                <img class="wbblog_img img-responsive"
                                                                    src="/ART01/artista_01/modules/wbblog/views/img/home_blog-3.jpg"
                                                                    alt="This is Third Post For wbBlog">
                                                                <div class="blog_mask content">
                                                                    <div class="blog_mask_content">
                                                                        <a class="thumbnail_lightbox icon"
                                                                            href="/ART01/artista_01/modules/wbblog/views/img/large-3.jpg"
                                                                            data-lightbox="example-set">
                                                                            <i class="material-icons">zoom_in</i>
                                                                        </a>
                                                                        <a href="#"
                                                                            class="icon"><i
                                                                                class="material-icons">shuffle</i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="blogdt date-time">
                                                                    <h3 class="blogda">10</h3>
                                                                    <h3 class="blogmo">Feb</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="blog_post_content_bottom text-xs-left">
                                                            <h3 class="post_title"><a
                                                                    href="#">This
                                                                    is Third Post For wbBlog</a></h3>
                                                            <div class="post_content">
                                                                <p>Lorem Ipsum is simply dummy text of the printing
                                                                    and typesetting industry. Lorem Ipsum has been
                                                                    the industrys standard dummy text ever since the
                                                                    1500s, when an ...</p>
                                                            </div>
                                                            <a class="read_more btn btn-primary"
                                                                href="#">Read
                                                                More</a>
                                                        </div>
                                                    </div>
                                                </article>
                                               
                                                <article class="blog_post col-xs-12 cless">
                                                    <div class="blog_post_content">
                                                        <div class="blog_post_content_top">
                                                            <div class="post_thumbnail">
                                                                <img class="wbblog_img img-responsive"
                                                                    src="/ART01/artista_01/modules/wbblog/views/img/home_blog-5.jpg"
                                                                    alt="How to Dress Like a Fashionista">
                                                                <div class="blog_mask content">
                                                                    <div class="blog_mask_content">
                                                                        <a class="thumbnail_lightbox icon"
                                                                            href="/ART01/artista_01/modules/wbblog/views/img/large-5.jpg"
                                                                            data-lightbox="example-set">
                                                                            <i class="material-icons">zoom_in</i>
                                                                        </a>
                                                                        <a href="#"
                                                                            class="icon"><i
                                                                                class="material-icons">shuffle</i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="blogdt date-time">
                                                                    <h3 class="blogda">10</h3>
                                                                    <h3 class="blogmo">Feb</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="blog_post_content_bottom text-xs-left">
                                                            <h3 class="post_title"><a
                                                                    href="#">How
                                                                    to Dress Like a Fashionista</a></h3>
                                                            <div class="post_content">
                                                                <p>The click of my Louboutins against the New York
                                                                    City pavement is lost on the ears of passersby
                                                                    as the horn of the taxi I’m about to hail is
                                                                    slammed by the ...</p>
                                                            </div>
                                                            <a class="read_more btn btn-primary"
                                                                href="#">Read
                                                                More</a>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="logos">
                                <div class="container">
                                    <div class="row">
                                        <div data-interval="5000" data-wrap="true" data-pause="hover">
                                            <ul id="owl-logo" class="rslide owl-carousel owl-theme">
                                                <li class="lslide col-xs-12">
                                                    <a
                                                        href="#">
                                                        <img src="https://prestashop.dostguru.com/ART01/artista_01/modules/wblogoslider/views/img/menufacture-1.jpg"
                                                            alt="menufacture-1" class="img-responsive center-block"
                                                            width=225 height=150 />
                                                    </a>
                                                </li>
                                                <li class="lslide col-xs-12">
                                                    <a
                                                        href="#">
                                                        <img src="https://prestashop.dostguru.com/ART01/artista_01/modules/wblogoslider/views/img/menufacture-2.jpg"
                                                            alt="menufacture-2" class="img-responsive center-block"
                                                            width=225 height=150 />
                                                    </a>
                                                </li>
                                                <li class="lslide col-xs-12">
                                                    <a
                                                        href="#">
                                                        <img src="https://prestashop.dostguru.com/ART01/artista_01/modules/wblogoslider/views/img/menufacture-3.jpg"
                                                            alt="menufacture-3" class="img-responsive center-block"
                                                            width=225 height=150 />
                                                    </a>
                                                </li>
                                                <li class="lslide col-xs-12">
                                                    <a
                                                        href="#">
                                                        <img src="https://prestashop.dostguru.com/ART01/artista_01/modules/wblogoslider/views/img/menufacture-4.jpg"
                                                            alt="menufacture-4" class="img-responsive center-block"
                                                            width=225 height=150 />
                                                    </a>
                                                </li>
                                                <li class="lslide col-xs-12">
                                                    <a
                                                        href="#">
                                                        <img src="https://prestashop.dostguru.com/ART01/artista_01/modules/wblogoslider/views/img/menufacture-5.jpg"
                                                            alt="menufacture-5" class="img-responsive center-block"
                                                            width=225 height=150 />
                                                    </a>
                                                </li>
                                                <li class="lslide col-xs-12">
                                                    <a
                                                        href="#">
                                                        <img src="https://prestashop.dostguru.com/ART01/artista_01/modules/wblogoslider/views/img/menufacture-6.jpg"
                                                            alt="menufacture-6" class="img-responsive center-block"
                                                            width=225 height=150 />
                                                    </a>
                                                </li>
                                                <li class="lslide col-xs-12">
                                                    <a
                                                        href="#">
                                                        <img src="https://prestashop.dostguru.com/ART01/artista_01/modules/wblogoslider/views/img/menufacture-7.jpg"
                                                            alt="menufacture-7" class="img-responsive center-block"
                                                            width=225 height=150 />
                                                    </a>
                                                </li>
                                                <li class="lslide col-xs-12">
                                                    <a
                                                        href="#">
                                                        <img src="https://prestashop.dostguru.com/ART01/artista_01/modules/wblogoslider/views/img/menufacture-8.jpg"
                                                            alt="menufacture-8" class="img-responsive center-block"
                                                            width=225 height=150 />
                                                    </a>
                                                </li>
                                                <li class="lslide col-xs-12">
                                                    <a
                                                        href="#">
                                                        <img src="https://prestashop.dostguru.com/ART01/artista_01/modules/wblogoslider/views/img/menufacture-9.jpg"
                                                            alt="menufacture-9" class="img-responsive center-block"
                                                            width=225 height=150 />
                                                    </a>
                                                </li>
                                                <li class="lslide col-xs-12">
                                                    <a
                                                        href="#">
                                                        <img src="https://prestashop.dostguru.com/ART01/artista_01/modules/wblogoslider/views/img/menufacture-10.jpg"
                                                            alt="menufacture-10" class="img-responsive center-block"
                                                            width=225 height=150 />
                                                    </a>
                                                </li>
                                                <li class="lslide col-xs-12">
                                                    <a
                                                        href="#">
                                                        <img src="https://prestashop.dostguru.com/ART01/artista_01/modules/wblogoslider/views/img/menufacture-11.jpg"
                                                            alt="menufacture-11" class="img-responsive center-block"
                                                            width=225 height=150 />
                                                    </a>
                                                </li>
                                                <li class="lslide col-xs-12">
                                                    <a
                                                        href="#">
                                                        <img src="https://prestashop.dostguru.com/ART01/artista_01/modules/wblogoslider/views/img/menufacture-12.jpg"
                                                            alt="menufacture-12" class="img-responsive center-block"
                                                            width=225 height=150 />
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <footer class="page-footer">
                        </footer>
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection