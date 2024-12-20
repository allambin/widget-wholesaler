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
const formattedPacks = ref([]);

const formatPacks = (packs) => {
  const data = Object.values(
    packs.reduce((acc, { quantity }) => {
      if (!acc[quantity]) {
        acc[quantity] = { quantity, count: 0 };
      }
      acc[quantity].count += 1;
      return acc;
    }, {})
  );
  data.sort((a, b) => {
    // sort by count DESC
    if (b.count !== a.count) {
      return b.count - a.count;
    }
    // sort by quantity DESC
    return b.quantity - a.quantity;
  });
  return data;
}

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
      const packs = data.packs;
      formattedPacks.value = formatPacks(packs);
      modal_success.showModal();
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
    <dialog id="modal_success" class="modal">
      <div class="modal-box">
        <h3 class="text-lg font-bold">Purchase successful!</h3>
        <p class="py-4">Here is what you will receive:</p>
        <ul>
          <li v-for="item in formattedPacks">{{ item.quantity }} x {{ item.count }}</li>
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