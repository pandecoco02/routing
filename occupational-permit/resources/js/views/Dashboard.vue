<script setup>
import { ref, computed } from "vue";
import { useStore } from 'vuex'

const store = useStore();


const user = computed(() => store.state.auth.user);
</script>
<template>
    <h1>Hello, {{ user.name }}</h1>
</template>