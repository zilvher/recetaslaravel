<template>
  <input 
    type="submit" 
    class="btn btn-danger d-block w-100 mb-2" 
    value ="Eliminar"
    v-on:click="eliminarReceta">
</template>

<script>
export default {
  props: ['recetaId'],
  
  methods:{
    eliminarReceta(){
      this.$swal({
        title: '¿Deseas eliminar esta receta?',
        text: 'Una vez eliminada, no se podra recuperar',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
      }).then((result)=>{
        if(result.value){
          this.$swal({
            title: 'Receta Eliminada',
            text: 'Se elimino la receta',
            icon: 'success'
          })
        }

      })
    }

  }
}
</script>

<style>

</style>