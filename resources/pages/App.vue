<script setup>
import {ref} from "vue";

const value = ref(new Date());
</script>

<template>
    <h1 class="text-slate-400 hover:text-sky-400">hello world</h1>\

    <el-calendar v-model="value"/>
</template>

<style scoped>

</style>
