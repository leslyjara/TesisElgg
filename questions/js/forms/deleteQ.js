
$("#all").click(function() {           
    if($("#all").is(":checked")){
        $('input[type="checkbox"]').prop('checked', true);
    }else{
        $('input[type="checkbox"]').prop('checked', false);
    }       
});


$("#eliminar").click(function(e) {
    e.preventDefault();
    data={};   

    $('form').find('[name]').each( function( i , v ){
        var input = $(this), // resolves to current input element.
        name = input.attr('name');      
        value = input.val();             
        if($(this).is(":checked")){
            data[name] = value;
        }
        if( name=='container'){ 
           data[name] = value; 
        } 
        if(name=='group'){
            data[name]=value;
        }
    });       
    

    require(['elgg/Ajax'], Ajax => {
        var ajax = new Ajax();
        ajax.action('questions/deleteQ',{
            data:data,
            
        }).done(function(output,statusText, jqXHR){
        
            if (jqXHR.AjaxData.status == -1) {
                return;
            }   
            ajax.form('questions/deleteQ',{
                data:data,
            }).done(function (output, statusText, jqXHR) {
                if (jqXHR.AjaxData.status == -1) {
                    return;
                }        
                $('#view-form').html(output);                
                
            });        
        });                 
    })
    


});
//---------------------------------------------------------------------
$("#agregar").click(function(e) {
    alert("agregar");
    e.preventDefault();
    data={};

    $('form').find('[name]').each( function( i , v ){
        var input = $(this), // resolves to current input element.
        name = input.attr('name');      
        value = input.val();             
        if($(this).is(":checked")){
            data[name] = value;
        }
        if( name=='container'){ 
            data[name] = value;                              
        }       
    });       


    require(('elgg/Ajax'), Ajax => {
        var ajax = new Ajax();
        ajax.action('questions/deleteQ',{
            data:data,
        }).done(function(output,statusText, jqXHR){
        
            if (jqXHR.AjaxData.status == -1) {
                return;
            }   
            ajax.form('questions/deleteQ',{
                data:data
            }).done(function (output, statusText, jqXHR) {
                if (jqXHR.AjaxData.status == -1) {
                    return;
                }        
                $('#view-form').html(output);
                
            });  
        });                 
    })
    


});


$("select[name='setContainer']" ).change(function(e){
  
    
    data={};
    data['container']= $(this).val();
    data['categoria']= $(this).val();
    data['group']= $('input:hidden[name=group]').val(); 
    data['cuestionario']= $('input:hidden[name=cuestionario]').val(); 
   
   //carga formulario: listado de preguntas
   require(['elgg/Ajax'], Ajax => {
        var ajax = new Ajax();
        ajax.form('questions/deleteQ',{
            data:data
        }).done(function (output, statusText, jqXHR) {
            if (jqXHR.AjaxData.status == -1) {
                return;
            }        
            console.log("salida") ;
        $('#view-form').html(output);                    
        });          
    }); 
   
});

