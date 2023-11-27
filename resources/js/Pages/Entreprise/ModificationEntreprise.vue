<template>
    <div
        class="modal fade"
        id="modifierEntrepriseModal"
        data-backdrop="static"
        data-keyboard="false"
        tabindex="-1"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        Edition de l'entreprise " {{ editEntreprise.nom }} "
                    </h5>
                    <button
                        type="button"
                        class="close"
                        @click="closeModal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form id="editForm" @submit.prevent="soumettre">
                        <div class="form-group">
                            
                            <label for="">Nom entreprise</label>

                            <input 
                            type="text" 
                            class="form-control" 
                            v-model="editEntreprise.nom" 
                            :class="{'is-invalid': editEntreprise.nomErreur != ''}" 
                            required>

                            <span v-if=" editEntreprise.nomErreur != '' " class="invalid-feedback error"> {{ editEntreprise.nomErreur }} </span>

                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="closeModal"
                    >
                        Fermer
                    </button>
                    <button form="editForm" type="submit" class="btn btn-success">
                        Soumettre
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import { Axios } from "axios";
import {reactive, watch} from "vue";
import {router} from "@inertiajs/vue3";
import { useSwalSuccess, useSwalError } from "../../Composables/alert";

const emit = defineEmits(["modalClosed"])

const props = defineProps({
    entrepriseId: {
        type: Number,
        reactive: true
    },
    show: {
        type: Boolean,
        default: false
    }
})

const editEntreprise = reactive({
    id: "",
    nom: "",
    nomErreur: ""
})

const soumettre = ()=> {
    router.put(route("entreprise.update", {entreprise: props.entrepriseId}), {
        nom_entreprise: editEntreprise.nom
    }, {
        onSuccess: (response)=>{
            useSwalSuccess("Nom entreprise modifié avec succès")
            closeModal()
        },
        onError: (error)=>{
            editEntreprise.nomErreur = "Ce nom existe déjà"
            useSwalError("Une erreur a été rencontrée")
        }
    })
}

const openModal = ()=>{
    getEntrepriseById()
    $("#modifierEntrepriseModal").modal("show")
}

const closeModal = ()=>{
    $("#modifierEntrepriseModal").modal("hide")
    emit("modalClosed")

}

const getEntrepriseById = ()=> {
    axios.get(route("entreprise.modification", {entreprise: props.entrepriseId}
    )).then((response)=> {
        editEntreprise.id = response.data.entreprise.id
        editEntreprise.nom = response.data.entreprise.nom_entreprise
        console.log("response : ", response.data)
    }).catch((error)=> {
        console.log(error)
    })
}

watch(
    ()=> props.show,
    (newVal, oldVal)=>{
        if (newVal) {
            openModal()
        } else {
            closeModal()
        }
    }
)

</script>
