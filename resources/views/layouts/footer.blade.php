<footer class="text-center text-lg-start bg-body-tertiary text-muted" style="background-color: rgba(0, 0, 0, 0.05);">

  <section class="pt-1">
    <div class="container text-center text-md-start">

      <div class="row">

        <div class="col-md-3 col-lg-3 col-xl-4 mx-auto mb-4">

          <h6 class="text-uppercase fw-bold mb-4">
            Sitios de Interes
          </h6>
          @guest
          <p>
            <a href="{{ route('home') }}" class="text-reset">Películas destacadas</a>| 
            <a href="{{ route('login') }}" class="text-reset">Regístrate</a>
          </p>
          @else
          <p>
            <a href="{{ route('home') }}" class="text-reset">Películas destacadas</a> |
            <a href="{{ route('recommendation.index') }}" class="text-reset">Recomendaciones</a> |
            <a href="{{route('config')}}" class="text-reset">Configurar Perfil</a>
          </p>
          @endguest
        </div>

        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

          <h6 class="text-uppercase fw-bold mb-4">Contactanos</h6>
          <p>
            <i class="fas fa-envelope me-3"></i>
            info@recomendaciones.com
          </p>
          <p><i class="fas fa-phone me-3"></i> +34 678 123 456</p>
        </div>

      </div>

    </div>
  </section>

<section class="d-flex justify-content-center">

    <div class="me-5 d-none d-lg-block">
      <span>Redes sociales :</span>
    </div>

    <div>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-twitter"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-google"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-instagram"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-linkedin"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-github"></i>
      </a>
    </div>
      
  </section>
    
  <div class="text-center p-4">
    © 2024 Copyright:
    <a class="text-reset fw-bold" href="">Recomendaciones.com</a>
  </div>

</footer>