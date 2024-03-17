<?php
    use Carbon\Carbon;
    $año = Carbon::now()->format('Y');
?>

<div class="nk-footer">
    <div class="container-fluid">
        <div class="nk-footer-wrap">
            <div class="nk-footer-copyright"> &copy; {{$año}} SolucionesMW. Todos los derechos reservados.<a class="text-primary" href="https://www.solucionesmw.com/" target="_blank">https://www.solucionesmw.com/</a>
            </div>
            
        </div>
    </div>
</div>