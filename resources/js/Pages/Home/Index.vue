<script setup>
import { ref } from 'vue';
import Layout from '@/Layouts/Layout.vue';
import { Head } from '@inertiajs/vue3'
import PackCard from '@/Components/PackCard.vue';
import CustomPackCard from '@/Components/CustomPackCard.vue';
import ErrorMessage from '@/Components/ErrorMessage.vue';

const props = defineProps({
  packs: Array,
  buyUrl: String
});

const errorMsg = ref(null);
const packsWithQuantity = ref([]);

const buyPacks = async (quantity) => {
  try {
    const response = await fetch(props.buyUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      },
      body: JSON.stringify({ quantity: quantity }),
    });

    const data = await response.json();

    if (!response.ok) {
      errorMsg.value = 'Failed to purchase packs';
      console.log(data);
    } else {
      const quantities = data.quantities;
      const t = Object.values(
        quantities.reduce((acc, pack) => {
          if (!acc[pack]) {
            acc[pack] = { pack, quantity: 0 };
          }
          acc[pack].quantity += 1;
          return acc;
        }, {})
      );
      t.sort((a, b) => {
        // sort by quantity DESC
        if (b.quantity !== a.quantity) {
          return b.quantity - a.quantity;
        }
        // sort by pack DESC
        return b.pack - a.pack;
      });
      packsWithQuantity.value = t;
      my_modal_1.showModal();
      console.log(packsWithQuantity);
    }
  } catch (error) {
    errorMsg.value = 'Failed to purchase packs';
    console.error('Error during purchase:', error);
  }
}
</script>

<template>
  <Layout>
    <Head title="Welcome" />
    <dialog id="my_modal_1" class="modal">
      <div class="modal-box">
        <h3 class="text-lg font-bold">Purchase successful!</h3>
        <p class="py-4">Here is what you will receive:</p>
        <ul>
          <li v-for="item in packsWithQuantity">{{ item.pack }} x {{ item.quantity }}</li>
        </ul>
        <div class="modal-action">
          <form method="dialog">
            <button class="btn">Close</button>
          </form>
        </div>
      </div>
    </dialog>
    <ErrorMessage :message="errorMsg" v-if="errorMsg" />
    <div class="grid grid-cols-3 gap-4 mb-10 mx-auto">
      <CustomPackCard :buy-url="buyUrl" @buy="buyPacks" />
      <div v-for="pack in packs" :key="pack.id">
        <PackCard :pack="pack" @buy="buyPacks" />
      </div>
    </div>
  </Layout>
</template>