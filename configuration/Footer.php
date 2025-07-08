<!-- Footer -->
<footer>
    <br>
    <div>
        <h3> Design by Eng / Samer Shuaa &copy; <span id="CurrentYear"></span> </h3>
    </div>
    <br>
</footer>
<script>
    PHP.CurrentFile = '<?=$CurrentFile?>';
    PHP.CurrentDate = '<?=$CurrentDate?>';
    PHP.CurrentTime = <?=json_encode($CurrentTime)?>;
    PHP.MaxDate = '<?=$_SESSION['MaxDate']?>';
    PHP.MinDate = '<?=$_SESSION['MinDate']?>';
    PHP.SelectDate  = '<?=$_SESSION['SelectDate']?>';
    PHP.Request = <?=json_encode($_REQUEST)?>;
    PHP.Sesstion = <?=json_encode($_SESSION)?>;

    <?php if (isset($CurrentFile) && in_array($CurrentFile, ['show-courier','history', 'show-daily', 'reports','table-synop','Mater-Reports','Show-Mater','backup'])) { ?>
    $(document).ready(function () {
        $(function () {
            $("#_date_").datepicker({
                changeYear: true,
                changeMonth: true,
                dateFormat: 'yy-mm-dd',
                minDate: PHP.MinDate,
                maxDate: PHP.MaxDate
            });
        });
    });
    <?php } ?>

    <?php if (isset($CurrentFile) && $CurrentFile === 'daily-monitoring') { ?>
    var $SetTimesOptions_daily = <?php daily_monitoring_date() ?>;
    var $ErrorTimesOptions_daily = <?php daily_Error(); ?>;
    <?php } ?>

    <?php if (isset($CurrentFile) && in_array($CurrentFile,['courier']) ) { ?>
    var $SetTimesOptions_courier = <?php courier_date(); ?>;
    var $ErrorTimesOptions_courier = <?php courier_Error(); ?>;
    <?php } ?>

    <?php if (isset($CurrentFile) && in_array($CurrentFile,['synop']) ) { ?>
    var $SetTimesOptions_synop$ = <?php synop_date(); ?>;
    <?php } ?>

    <?php if (isset($CurrentFile) && in_array($CurrentFile,['show-synop']) ) { ?>
    var $SetStationX$ = <?php echo json_encode(SetStationX()); ?>;
    <?php } ?>

</script>

<?php
if ( isset( $_REQUEST[ 'message' ] ) )
{
  $Message = $_REQUEST[ 'message' ];
  echo "<script>swal({ title: 'تم حفظ التغييرات', text: '$Message', icon: 'success', button: 'مــوافــق' }); Focus('time'); </script>";
}
foreach (_SESSION_('Message',[]) as $Value)
{
  echo "<script>swal({ title: '{$Value['Title']}', text: '{$Value['Body']}', icon: '{$Value['Icon']}',button: '{$Value['Button']}' }); </script>";
}
  $_SESSION['Message'] = [];
?>

<!-- End Footer -->
<?php if(file_exists("js/$CurrentFile.js")):?>
    <script src="js/<?php echo $CurrentFile; ?>.js"></script>
<?php endif;?>

</body>
<style>

</style>
</html>

<?php
if (isset($_SESSION['per']) && $_SESSION['per'] !== 'admin')
{
    $_SESSION['Station'] = $_SESSION['Save-Station'];
}
?>