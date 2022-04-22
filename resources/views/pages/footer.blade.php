<?php
    use Carbon\Carbon;
    $año = Carbon::now()->format('Y');
?>

<div class="nk-footer">
    <div class="container-fluid">
        <div class="nk-footer-wrap">
            <div class="nk-footer-copyright"> &copy; {{$año}} DashLite. Template by <a href="https://softnio.com" target="_blank">Softnio</a>
            </div>
            
        </div>
    </div>
</div>