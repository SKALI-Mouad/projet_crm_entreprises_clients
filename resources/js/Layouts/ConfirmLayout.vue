<template>
    <div class="wrapper ">

        <div class="">
            <slot />
        </div>

        <!--On doit eliminer cette sidebar ici-->
        <aside class="control-sidebar control-sidebar-dark">
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>

        <Footer />

    </div>
</template>

<script setup>
    import Footer from './Partials/Footer.vue';
</script>
