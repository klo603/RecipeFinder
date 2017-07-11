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
        }).done(function( html ) {
            var json = JSON.parse(html);
            if (json.error == true){
                $('#error_wrapper').show();
                $('#results_wrapper').hide();
                $('#error_wrapper').html(json.message);
            } else {
                $('#results_wrapper').show();
                $('#error_wrapper').hide();
                for(var i = 0; i < json.recipes.length; i++){
                    var recipeHtml = '<li>';
                    recipeHtml += '<h3>'+json.recipes[i].name+'</h3>';
                    recipeHtml += '<ul>';
                    for(var k = 0; k < json.recipes[i].ingredients.length; k++) {
                        if (json.recipes[i].ingredients[k].unit == 'of'){
                            recipeHtml += '<li>'+json.recipes[i].ingredients[k].amount+' '+json.recipes[i].ingredients[k].item+'</li>';
                        } else {
                            recipeHtml += '<li>'+json.recipes[i].ingredients[k].item+', '+json.recipes[i].ingredients[k].amount+' '+json.recipes[i].ingredients[k].unit+'</li>';
                        }

                    }
                    recipeHtml += '</ul>';
                    recipeHtml += '</li>';
                    $('#results').append($(recipeHtml));
                }

            }
        }).fail(function( html ) {
            $('#results_wrapper').hide();
            $('#error_wrapper').show();
            $('#error_wrapper').html('System error, please try again later');
        });
    });
});