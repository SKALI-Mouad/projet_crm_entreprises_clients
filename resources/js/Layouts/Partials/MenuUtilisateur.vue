<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <img src="/images/tersea_logo.png" alt="" class="brand-image img-circle elevation-3"
                    style="opacity: 0.8" />
                <span class="brand-text font-weight-light">Tersea</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="~admin-lte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image" />
                    </div>
                    <div class="info">
                        <Link href="#" class="d-block"> {{ user.nom }} </Link>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        
                        <li class="nav-item">
                            <Link :href="route('utilisateur.index')" class="nav-link" :class="{ 'active' : $page.component == 'Utilisateur/IndexUtilisateur'}">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Ma Entreprise
                                </p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('utilisateur.modification', {employe: userId})" class="nav-link" :class="{ 'active' : $page.component == 'Utilisateur/ModificationUtilisateur'}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Modifier mon profile
                                </p>
                            </Link>
                        </li>

                        <li class="nav-item">
                            <Link href="/logoutUser" method="post" as="button" type="button" class="btn btn-block btn-danger btn-lg">
                                Déconnexion
                            </Link>
                        </li>
                        
                    </ul>
                </nav>
            </div>
        </aside>
</template>

<script setup>
    import { usePage } from '@inertiajs/vue3';
    import { computed } from 'vue';

    const user = computed(()=>{
        return usePage().props.auth.user
    })
    //console.log(usePage().props.auth.user.nom)

    const userId = computed(()=>{
        return usePage().props.userInfo.id
        
    })


</script>
