<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des employés de "{{ entreprises.nom_entreprise }}"</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <Link :href="route('utilisateur.modification', {employe: userId})" class="btn btn-primary">
                        <i class="fa fa-plus"> Modifier mon profile</i>
                        </Link>
                    </div>
                    <div class="card-tools">
                        <Pagination
                            :links="props.employes.links"
                            :prev="props.employes.prev_page_url"
                            :next="props.employes.next_page_url"
                        />
                    </div>
                </div>

                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <!--<th style="width: 10px">#</th>-->
                                <th>
                                    <p>Photo</p>
                                </th>
                                <th>
                                    <p>Employé</p>
                                    <!-- <input @keyup="search" v-model="searchEmploye" type="text" class="form-control"> -->
                                </th>
                                <th>
                                    <p>E-mail</p>
                                </th>
                                <th>
                                    <p>Entreprise :</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="employe in props.employes.data">
                                <td><img :src="showPic(employe)" style="width:45px; height:45px; border-radius:25px;"></td>
                                <td>{{ employe.nom_employe }} {{ employe.prenom_employe }}</td>
                                <td>{{ employe.email_employe }}</td>
                                <td>{{ employe.entreprise.nom_entreprise }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MainLayoutUtilisateur from "../../Layouts/MainLayoutUtilisateur.vue";
    export default {
        layout: MainLayoutUtilisateur
    }
</script>

<script setup>
    import Pagination from '../../Shared/Pagination.vue';
    import {ref} from "vue";
    import {router} from "@inertiajs/vue3";
    import { useSwalConfirm, useSwalSuccess, useSwalError } from '../../Composables/alert';

    import { usePage } from '@inertiajs/vue3';
    import { computed } from 'vue';

    //const userId = $userInfo->id;
    //console.log($userInfo);

    // const userId = $userInfo.id;
    const userId = computed(()=>{
        return usePage().props.userInfo.id
    })

    //console.log(usePage().props.userInfo);

    const user = computed(()=>{
        return usePage().props.auth.user
    })

    const props = defineProps({
        employes: Object,
        entreprises: Array,
        filtres: Object
    })

    const showPic = (employe)=>{
        if (employe.photo_employe) {
            return 'storage/'+employe.photo_employe
        } else {
            return '/images/image_de_base.jpeg'
        }
    }

    const searchEmploye = ref(props.filtres.search ?? "")
    const filtreEntreprise = ref(props.filtres.filtre ?? "")

    const search = _.throttle(function(){
            console.log("searchEmploye : ", searchEmploye.value)
            console.log("filtre : ", filtreEntreprise.value)
            router.get(route('employe.index', { search: searchEmploye.value, filtre: filtreEntreprise.value}), {}, {
            replace: true,
            preserveState: true
            })
        }, 500)
    
    const deleteEmploye = (id)=>{
        router.delete(route("employe.delete", {employe: id}), {
        onSuccess: (response)=>{
            useSwalSuccess("L'employé a été supprimé avec succès")
        },
        onError: (error)=>{
            useSwalError(error.message ?? "Une erreur a été rencontrée")
        }
        })
    }
    const deleteConfirmation = (employe)=>{
        let message = `Vous êtes sûre de vouloir supprimer l'employé " ${employe.nom_employe} ${employe.prenom_employe} " ?`;
        useSwalConfirm(message, ()=>{
            deleteEmploye(employe.id)
        });
        showModal.value = false;
    }

    

</script>
