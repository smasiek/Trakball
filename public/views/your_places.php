<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SQUADS PAGE</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/places.css">

    <!-- Required Core Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.min.css">

    <!-- Optional Theme Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.theme.min.css">

    <script src="https://kit.fontawesome.com/346296466a.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="base-container">
    <nav>
        <img src="public/img/Logo small.png">
        <ul>
            <li>
                <i class="fas fa-map-marked-alt"></i>
                <a href="#" class="button">map</a>
            </li>
            <li>
                <i class="fas fa-user-plus"></i>
                <a href="#" class="button">squads</a>
            </li>
            <li>
                <i class="fas fa-map-marker-alt"></i>
                <a href="#" class="button">your places</a>
            </li>
            <li>
                <i class="fas fa-user-friends"></i>
                <a href="#" class="button">your squads</a>
            </li>
            <li name="sign-in">
                <i class="fas fa-user-alt"></i>
                <a href="#" class="button">sign in</a>
            </li>
            <li name="log-out">
                <i class="fas fa-user-alt-slash"></i>
                <a href="#" class="button">log out</a>
            </li>
            <li>
                <i class="fas fa-cog"></i>
                <a href="#" class="button">settings</a>
            </li>
        </ul>
    </nav>
    <main>
        <header>
            <div class="search-bar">
                <form>
                    <input placeholder="search project">
                </form>
            </div>

            <div class="add-squad">
                <i class="fas fa-plus"></i>
                add squad
            </div>
        </header>

        <div class="your_places">
            <div class="glide">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        <li class="glide__slide">
                            <div id="place1">
                                <img src="public/img/uploads/meme.jpg">
                                <div class="footer">
                                    <p class="place_name">Place name</p>
                                    <p class="place_address">Place address</p>
                                    <div class="decision">
                                        <a href="#" class="squad-hyper">Show on map</a>
                                        <a href="#" class="squad-hyper">Show events</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="glide__slide">
                            <div id="place2">
                                <img src="public/img/uploads/meme2.jpg">
                                <div class="footer">
                                    <p class="place_name">Place name</p>
                                    <p class="place_address">Place address</p>
                                    <div class="decision">
                                        <a href="#" class="squad-hyper">Show on map</a>
                                        <a href="#" class="squad-hyper">Show events</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="glide__slide">
                            <div id="place3">
                                <img src="public/img/uploads/meme.jpg">
                                <div class="footer">
                                    <p class="place_name">Place name</p>
                                    <p class="place_address">Place address</p>
                                    <div class="decision">
                                        <a href="#" class="squad-hyper">Show on map</a>
                                        <a href="#" class="squad-hyper">Show events</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="glide__slide">
                            <div id="place4">
                                <img src="public/img/uploads/meme2.jpg">
                                <div class="footer">
                                    <p class="place_name">Place name</p>
                                    <p class="place_address">Place address</p>
                                    <div class="decision">
                                        <a href="#" class="squad-hyper">Show on map</a>
                                        <a href="#" class="squad-hyper">Show events</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="glide__slide">
                            <div id="place5">
                                <img src="public/img/uploads/meme.jpg">
                                <div class="footer">
                                    <p class="place_name">Place name</p>
                                    <p class="place_address">Place address</p>
                                    <div class="decision">
                                        <a href="#" class="squad-hyper">Show on map</a>
                                        <a href="#" class="squad-hyper">Show events</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="glide__slide">
                            <div id="place6">
                                <img src="public/img/uploads/meme2.jpg">
                                <div class="footer">
                                    <p class="place_name">Place name</p>
                                    <p class="place_address">Place address</p>
                                    <div class="decision">
                                        <a href="#" class="squad-hyper">Show on map</a>
                                        <a href="#" class="squad-hyper">Show events</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="glide__arrows" data-glide-el="controls">
                    <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fa fa-angle-left"></i></button>
                    <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fa fa-angle-right"></i></button>
                </div>
                </div>



        </div>
    </main>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/glide.min.js"></script>

<script>
    new Glide('.glide', {
        type: 'carousel',
        startAt: 0,
        perView: 3,
        focusAt: 'center',
    }).mount()
</script>

</body>
</html>