<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des entreprises</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">

                        <CreationEntreprise />

                    </div>
                    <div class="card-tools">

                        <Pagination 
                        :links="props.entreprises.links" 
                        :prev="props.entreprises.prev_page_url" 
                        :next="props.entreprises.next_page_url" 
                        />

                    </div>
                </div>

                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <!--<th style="width: 10px">#</th>-->
                                <th>Entreprise</th>
                                <!--<th>Progress</th>-->
                                <th style="width: 140px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="entreprise in props.entreprises.data">
                                <td>{{ entreprise.nom_entreprise }}</td>
                                <td>
                                    <div class="d-felx justify-content-center">
                                            <button @click="openmodifierEntrepriseModal(entreprise.id)" class="btn btn-info mb-2 mr-sm-2">
                                                <i class="fas fa-pen"></i>
                                            </button>

                                            <button @click="deleteConfirmation(entreprise)" class="btn btn-danger mb-2 mr-sm-2">
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

    <ModificationEntreprise 
    :entreprise-id="editingElementId"
    :show="showModal"
    @modal-closed="modalClosed"
    />

</template>

<script setup>
    import Pagination from '../../Shared/Pagination.vue';
    import CreationEntreprise from './CreationEntreprise.vue';
    import ModificationEntreprise from './ModificationEntreprise.vue';
    import {ref} from "vue";
    import { useSwalConfirm, useSwalSuccess, useSwalError } from '../../Composables/alert';
    import {router} from "@inertiajs/vue3";

    const editingElementId = ref(0)
    const showModal = ref(false)
    const props = defineProps({
        entreprises: Object
    })
    const deleteEntreprise = (id)=>{
        router.delete(route("entreprise.delete", {entreprise: id}), {
        onSuccess: (response)=>{
            useSwalSuccess("L'entreprise a été supprimé avec succès")
        },
        onError: (error)=>{
            useSwalError(error.message ?? "Une erreur a été rencontrée")
        }
        })
    }
    const deleteConfirmation = (entreprise)=>{
        let message = `Vous êtes sûre de vouloir supprimer l'entreprise " ${entreprise.nom_entreprise} " ? `;
        useSwalConfirm(message, ()=>{
            deleteEntreprise(entreprise.id)
        });
        showModal.value = false;
    }
    const modalClosed = ()=>{
        editingElementId.value = 0
        showModal.value = false
    }
    const openmodifierEntrepriseModal = (id)=> {
        editingElementId.value = id
        showModal.value = true
    }
</script>
