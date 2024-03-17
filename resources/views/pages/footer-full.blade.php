<?php
    use Carbon\Carbon;
    $año = Carbon::now()->format('Y');
?>
<div class="nk-footer nk-auth-footer-full">
    <div class="container wide-lg">
        <div class="row g-3">           
            <div class="col-lg-12 text-center">
                <div class="nk-block-content text-center text-lg-center">
                    <p class="text-soft">&copy; {{$año}} SolucionesMW. Todos los derechos reservados.<a href="https://www.solucionesmw.com/" target="_blank">https://www.solucionesmw.com/</a></p>
                </div>
            </div>
        </div>
    </div>
</div>