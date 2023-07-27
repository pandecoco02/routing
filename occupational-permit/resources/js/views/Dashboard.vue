
<script setup>

import { ref, computed, onMounted } from "vue";
import { useStore } from 'vuex'

const store = useStore();
const user = ref("");


onMounted(() => {
    user.value = JSON.parse(localStorage.getItem('user'));
    console.log(user.value.name);
});


</script>
<template>
    <h1>Hello, {{ user.name }}</h1>
    <p v-for="user in user.roles ">Position: {{ user.slug }}</p>
</template>