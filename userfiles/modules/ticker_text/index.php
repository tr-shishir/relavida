<style>
    .typed-cursor {
    display: none;
}
</style>
<div class="x-edit">
    <h1 style="height: 60px;" class="typed-<?php print $params['id']; ?>">
        <?php _e('Please save ticker text'); ?>
    </h1>
</div>
<?php 

$ticker_text_list = DB::table('options')->where('option_group',$params['id'])->orderBy('option_key', 'asc')->pluck('option_value')->toArray() ?? [];
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/1.1.1/typed.min.js"></script>
<script>
    ticker_text = <?php echo json_encode($ticker_text_list); ?>;
    $(".typed-<?php print $params['id']; ?>").typed({
        strings: ticker_text,
        typeSpeed: 100,
        loop: true
    });
</script>