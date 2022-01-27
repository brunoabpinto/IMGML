<template>
  <div class="h-screen pb-14">
    <Nav />

    <!--Main-->
    <div class="container md:pt-48 px-6 mx-auto flex flex-wrap flex-col md:flex-row justify-between">

      <!--Left Col-->
      <div class="flex flex-col w-full xl:w-2/5 justify-center items-center overflow-y-hidden">
        <h1 class="my-4 text-3xl md:text-5xl text-purple-800 font-bold leading-tight text-center md:text-left slide-in-bottom-h1">There are no images on this page</h1>
        <span class="rounded-lg overflow-hidden mb-5 cursor-pointer shadow-2xl w-[200px]" v-html="image" @click="refreshImage"></span>
        <h3 class="text-2xl mb-3 text-purple-900">No, not even this one</h3>
      </div>

      <!--Right Col-->
      <div class="flex flex-col w-full xl:w-2/5 justify-center items-center overflow-y-hidden">
        <h1 class="my-4 text-3xl md:text-5xl text-purple-800 font-bold leading-tight text-center md:text-left slide-in-bottom-h1">Upload an image!</h1>
        <Dropzone />
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import Dropzone from '../components/Dropzone.vue'
import Nav from '../components/Nav.vue'

export default {
  components: { Dropzone, Nav },
  props: {
    image: String
  },
  setup(props) {
    const image = ref(null);
    onMounted(() => {
      image.value = props.image;
    })

    function refreshImage() {
      Inertia.visit('/', { only: ['image'] })
    }

    return { image, refreshImage }
  }
}
</script>
