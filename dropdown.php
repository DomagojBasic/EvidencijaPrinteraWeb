<script>
<!--Procedura za dropdown objekt -->
    $(document).ready(function () {
    $('#objekt_list').change(function() {
        var selectedValue = $(this).val();
        getObjekt(selectedValue);
    });
});

function getObjekt(val) {
    $.ajax({
        type: "POST",
        url: "getObjekt.php",
        data: 'ImeObjekta=' + val,
        success: function (data) {
            $("#objekt_list").html(data);
        }
    });
    return false; // Prevent default form submission behavior

        }

    

    </script>