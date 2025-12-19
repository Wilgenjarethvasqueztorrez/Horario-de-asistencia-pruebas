<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>  
    $(document).ready(function() {  
        // Inicializar todos los selects con Select2  
        $('#select2').select2({  
            width: 'resolve',  
            language: "es"  
        });  

        $('#select2-rol').select2({  
            width: 'resolve', 
            language: "es"  
        });  
        $('#select2-empleado').select2({  
            width: 'resolve', 
            language: "es"  
        });  
    });  
</script>