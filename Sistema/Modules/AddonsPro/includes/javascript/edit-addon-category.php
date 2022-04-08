<script>

    if("<?=$addonCategory->type?>" == 'MULTI') {
        $('#_min_and_max').show();
        $('#_required_option').show();
    }else{
        $('#_min_and_max').hide();
        $('#_required_option').hide();
    }

    $('.select').on('change', function() {
        if(this.value == 'MULTI') {
            $('#_min_and_max').show();
            $('#_required_option').show();
        }else{
            $('#_min_and_max').hide();
            $('#_required_option').hide();
        }
    });

</script>
