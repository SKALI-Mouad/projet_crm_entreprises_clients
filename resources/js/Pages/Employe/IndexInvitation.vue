<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des employées</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        
                        <Link :href="route('employe.creation')" class="btn btn-primary">
                        <i class="fa fa-plus"> Nouveau Employé</i>
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
                                <th>
                                    <p>Photo</p>
                                </th>
                                <th>
                                    <p>Employé</p>
                                    <input @keyup="search" v-model="searchEmploye" type="text" class="form-control">
                                </th>
                                <th>
                                    <p>E-mail</p>
                                </th>
                                <th>
                                    <p>Entreprise</p>
                                    <select @change="search" v-model="filtreEntreprise" type="text" class="form-control">
                                        <option value="" selected>Choix entreprise</option>
                                        <option :value="entreprise.id" :key="entreprise.id" v-for="entreprise in props.entreprises">
                                            {{ entreprise.nom_entreprise }}
                                        </option>
                                    </select>
                                </th>
                                <!--<th>Progress</th>-->
                                <th style="width: 140px">
                                    <p>Action</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="employe in props.employes.data">
                                <td><img :src="showPic(employe)" style="width:45px; height:45px; border-radius:25px;"></td>
                                <td>{{ employe.nom_employe }} {{ employe.prenom_employe }}</td>
                                <td>{{ employe.email_employe }}</td>
                                <td>{{ employe.entreprise.nom_entreprise }}</td>
                                <td>
                                    <div class="d-felx justify-content-center">
                                        <button @click="deleteConfirmation(employe)" class="btn btn-danger mb-2 mr-sm-2">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import Pagination from '../../Shared/Pagination.vue';
    import {ref} from "vue";
    import {router} from "@inertiajs/vue3";
    import { useSwalConfirm, useSwalSuccess, useSwalError } from '../../Composables/alert';

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
            router.get(route('employe.indexInvitation', { search: searchEmploye.value, filtre: filtreEntreprise.value}), {}, {
            replace: true,
            preserveState: true
            })
        }, 500)
    
    const deleteEmploye = (id)=>{
        router.delete(route("employe.deleteInvitation", {employe: id}), {
        onSuccess: (response)=>{
            useSwalSuccess("L'invitation de l'employé a été supprimé avec succès")
        },
        onError: (error)=>{
            useSwalError(error.message ?? "Une erreur a été rencontrée")
        }
        })
    }
    const deleteConfirmation = (employe)=>{
        let message = `Vous êtes sûre de vouloir supprimer l'invitation de ce employé " ${employe.nom_employe} ${employe.prenom_employe} " ?`;
        useSwalConfirm(message, ()=>{
            deleteEmploye(employe.id)
        });
        showModal.value = false;
    }

    

</script>
