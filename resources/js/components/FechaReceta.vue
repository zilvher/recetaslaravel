<template>
  <span >{{formatearFecha}}</span>
</template>

<script>
    export default {
        props:['fecha'],
        // mounted(){
        //     return console.log(this.fecha);
        // },
        computed:{
            formatearFecha(){
                return moment(this.fecha).locale('es').format('DD [de] MMMM [del] YYYY')
            }
        }
    }
</script>

<style>

</style>