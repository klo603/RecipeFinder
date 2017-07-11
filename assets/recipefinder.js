$(document).ready(function(){
    $('#find_recipe_btn').on('click',function(){
        var formData = new FormData();
        formData.append('fridge_csv', $('#fridge_csv')[0].files[0]); 
        formData.append('recipe_json', $('#recipe_json')[0].files[0]); 
        // AJAX to give two files
        $.ajax({
            url: 'php/ajax/findrecipe.php',
            data: formData,
            type: 'POST',
            contentType: false,
            processData: false,
        });
    });
});