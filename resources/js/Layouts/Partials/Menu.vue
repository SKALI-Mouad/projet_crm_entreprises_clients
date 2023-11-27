<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="/" class="brand-link">
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
                            <Link :href="route('entreprise.index')" class="nav-link" :class="{ 'active' : $page.component == 'Entreprise/IndexEntreprise'}">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Entreprises
                                </p>
                            </Link>
                        </li>

                        <li class="nav-item" :class="{ 'menu-open' : $page.component.startsWith('Employe/')}">
                            <a href="#" class="nav-link" :class="{ 'active' : $page.component.startsWith('Employe/')}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Employés
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a :href="route('employe.index')" class="nav-link" :class="{ 'active' : $page.component.startsWith('Employe/IndexEmploye')}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tous les employée</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a :href="route('employe.indexInvitation')" class="nav-link" :class="{ 'active' : $page.component.startsWith('Employe/IndexInvitation')}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Invitations envoyées</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a :href="route('employe.creation')" class="nav-link" :class="{ 'active' : $page.component.startsWith('Employe/Creation')}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Nouvelle invitation</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <Link :href="route('employe.activityLog')" class="nav-link" :class="{ 'active' : $page.component == 'Log/ActivityLog'}">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Historique d'activité
                                </p>
                            </Link>
                        </li>

                        <li class="nav-item">
                            <Link href="/logoutAdmin" method="post" as="button" type="button" class="btn btn-block btn-danger btn-lg">
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
</script>
