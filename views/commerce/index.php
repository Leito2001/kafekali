<?php
require_once('../../core/helpers/commerce.php');
Commerce::headerTemplate('Kafekali · El arte del café');
?>
    <!--Slider con indicadores, altura de 400px y una duración entre transiciones de 6 segundos-->
    <div class="slider">
        <ul class="slides">

            <li>
                <img src="../../resources/img/1.jpeg"> 
                <div class="caption center-align">
                    <h3>Exfoliante de café</h3>
                    <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
                </div>
            </li>

            <li>
                <img src="../../resources/img/6.jpeg">
                <div class="caption left-align">
                    <h3>Sérum de café</h3>
                    <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
                </div>
            </li>

            <li>
                <img src="../../resources/img/18.jpeg">
                <div class="caption right-align">
                    <h3>Jabón de café</h3>
                    <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
                </div>
            </li>

            <li>
                <img src="../../resources/img/6.jpeg">
                <div class="caption center-align">
                    <h3>Aceite de café</h3>
                    <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
                </div>
            </li>

        </ul>
    </div>

    <!--Contenido-->
    <div class="container">
        
        <!--1. Sobre nosotros-->
        <div class="row" id="info">
            <h5 class="center white-text">Sobre nosotros</h5>

            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                        <img src="../../resources/img/equipo_kafekalie.png">
                    </div>
                </div>
            </div>

            <div class="col s12 m8">       
                <p><b>Kafekali, el arte del café.</b>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                    Quibusdam inventore illo voluptatem ex ea reiciendis, vitae sed praesentium reprehenderit,
                    Natus, consequatur nostrum cupiditate repellendus recusandae hic perspiciatis velit, 
                    pariatur ipsa, nulla quasi eum aliquam eaque ea in autem sunt veniam odio.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                    Natus, consequatur nostrum cupiditate repellendus recusandae hic perspiciatis velit, 
                    pariatur ipsa, nulla quasi eum aliquam eaque ea in autem sunt veniam odio.
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                    Natus, consequatur nostrum cupiditate repellendus recusandae hic perspiciatis velit.</p>
                    <b>Contáctanos: +503 78613311, kafekali@gmail.com</b>.</p>
                </div>
            </div>

            <!--2. Ventajas sobre nuestros productos-->

            <div class="row" id="productos">
                <h5 class="center white-text">Ventajas sobre nuestros productos</h5>

                <div class="col s6 m3">
                    <div class="card">

                    <!--Tarjeta 1-->
                        <div class="card-image waves-effect waves-block waves-light">
                            <img class="activator" src="../../resources/img/6.jpeg">
                        </div>
                        <div class="card-content">
                            <span class="card-title activator grey-text text-darken-4 center">Jabón de capucchino</span>
                        </div>
                        <div class="card-reveal">
                            <span class="card-title grey-text text-darken-4 center">Jabón de capucchino<i class="material-icons right">close</i></span>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam quos cumque nostrum veritatis adipisci 
                            maiores minus quasi autem ad. Quod quis omnis, excepturi accusamus quo dolor quam aperiam iusto quasi.</p>
                        </div>
                    </div>
                </div>

                <!--Tarjeta 2-->
                <div class="col s6 m3">
                    <div class="card">
                        <div class="card-image waves-effect waves-block waves-light">
                            <img class="activator" src="../../resources/img/8.jpeg">
                        </div>
                        <div class="card-content">
                            <span class="card-title activator grey-text text-darken-4 center">Jabón de capucchino</span>
                        </div>
                        <div class="card-reveal">
                            <span class="card-title grey-text text-darken-4 center">Jabón de capucchino<i class="material-icons right">close</i></span>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam quos cumque nostrum veritatis adipisci 
                            maiores minus quasi autem ad. Quod quis omnis, excepturi accusamus quo dolor quam aperiam iusto quasi.</p>
                        </div>
                    </div>
                </div>

                <!--Tarjeta 3-->
                <div class="col s6 m3">
                    <div class="card">
                        <div class="card-image waves-effect waves-block waves-light">
                            <img class="activator" src="../../resources/img/10.jpeg">
                        </div>
                        <div class="card-content">
                            <span class="card-title activator grey-text text-darken-4 center">Jabón de capucchino</span>
                        </div>
                        <div class="card-reveal">
                            <span class="card-title grey-text text-darken-4 center">Jabón de capucchino<i class="material-icons right">close</i></span>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam quos cumque nostrum veritatis adipisci 
                            maiores minus quasi autem ad. Quod quis omnis, excepturi accusamus quo dolor quam aperiam iusto quasi.</p>
                        </div>
                    </div>
                </div>

                <!--Tarjeta 4-->
                <div class="col s6 m3">
                    <div class="card">
                        <div class="card-image waves-effect waves-block waves-light">
                            <img class="activator" src="../../resources/img/12.jpeg">
                        </div>
                        <div class="card-content">
                            <span class="card-title activator grey-text text-darken-4 center">Jabón de capucchino</span>
                        </div>
                        <div class="card-reveal">
                            <span class="card-title grey-text text-darken-4 center">Jabón de capucchino<i class="material-icons right">close</i></span>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam quos cumque nostrum veritatis adipisci 
                            maiores minus quasi autem ad. Quod quis omnis, excepturi accusamus quo dolor quam aperiam iusto quasi.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Catálogo de productos-->
            <h5 class="center white-text" id="title">Catálogo de productos</h5>
            <!-- Fila para mostrar las categorías disponibles -->
            <div class="row" id="categorias"></div>
        </div>
    </div>

<?php
Commerce::footerTemplate('index.js');
?>