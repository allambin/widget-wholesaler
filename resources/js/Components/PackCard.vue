<script setup>
defineProps({
  pack: Object
});
</script>

<template>
  <div class="card bg-base-100 shadow-xl">
    <div class="card-body">
      <h2 class="card-title">{{ pack.quantity }}<small>widgets</small></h2>
      <p>Pack of {{ pack.quantity }} widgets</p>
      <div class="card-actions justify-end pt-10">
        <button class="btn btn-primary" @click="$emit('buy', pack.quantity)">Buy Now</button>
      </div>
    </div>
  </div>
</template>