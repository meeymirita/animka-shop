<script setup>
import SideBar from "../Components/SideBar.vue";
</script>

<template>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <SideBar/>
            </div>
            <div class="col-9">
                <slot/>
            </div>
        </div>
    </div>
</template>
