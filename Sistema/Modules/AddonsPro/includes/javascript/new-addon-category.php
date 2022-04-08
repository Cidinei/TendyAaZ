<script>
    $('.select').on('change', function() {
        if(this.value == 'MULTI') {
            $('#_min_and_max').show();
            $('#_required_option').show();
        }else{
            $('#_min_and_max').hide();
            $('#_required_option').hide();
        }
    });
    $(function() {
        if (Array.prototype.forEach) {
            var elems = Array.prototype.slice.call(document.querySelectorAll('.action-switch'));
            elems.forEach(function(html) {
                var switchery = new Switchery(html, { color: '#8360c3' });
            });
        }
        else {
            var elems = document.querySelectorAll('.action-switch');
            for (var i = 0; i < elems.length; i++) {
                var switchery = new Switchery(elems[i], { color: '#8360c3' });
            }
        }
    });
</script>
