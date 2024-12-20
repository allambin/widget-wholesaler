<script setup>
import { ref } from 'vue';

// const props = defineProps({ buyUrl: String })

// const quantity = defineModel()
const quantity = ref(0);

// const buy = async () => {
//   try {
//     const response = await fetch(props.buyUrl, {
//       method: 'POST',
//       headers: {
//         'Content-Type': 'application/json',
//         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
//       },
//       body: JSON.stringify({ quantity: quantity.value }),
//     })

//   //   if (!response.ok) {
//   //     throw new Error('Failed to purchase pack')
//   //   }

//     const data = await response.json()
//     console.log('Purchase successful:', data)
//     my_modal_1.showModal()
//   //   // Handle success (e.g., show a modal, update the UI, etc.)
//   } catch (error) {
//     console.error('Error during purchase:', error)
//   //   // Handle errors (e.g., show an error message)
//   }
// }

</script>

<template>
  <div class="card bg-base-100 shadow-xl">
    <div class="card-body">
      <h2 class="card-title">Custom</h2>
      <p><input v-model="quantity" type="number" class="w-3/5 input input-bordered input-sm w-full max-w-xs" /> widgets</p>
      <div class="card-actions justify-end">
        <button class="btn btn-accent" @click="$emit('buy', quantity)">Buy Now</button>
      </div>
    </div>
  </div>
</template>