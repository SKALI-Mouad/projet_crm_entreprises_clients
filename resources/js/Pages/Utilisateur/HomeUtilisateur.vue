<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="jumbotron">
                <h1 class="display-4">Bonjour, {{ user.nom }}</h1>
                <p class="lead">
                    Bienvenu sur notre application de gestion d'entreprises
                </p>
                <hr class="my-4">
                <p class="lead">
                    Si vous avez des problèmes, veuillez nous contacter au plus vite!
                </p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="#" role="button">Nous contacter</a>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { usePage } from '@inertiajs/vue3';
    import { computed } from 'vue';

    const user = computed(()=>{
        return usePage().props.auth.user
    })
    //console.log(usePage().props.auth.user.nom)
</script>