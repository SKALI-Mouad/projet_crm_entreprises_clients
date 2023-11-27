<template>
    <button class="btn btn-primary" data-toggle="modal" data-target="#creerNouvelleEntrepriseModal"><i class="fa fa-plus"> Nouvelle Entreprise</i></button>

    <div
        class="modal fade"
        id="creerNouvelleEntrepriseModal"
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
                        Ajout d'une entreprise
                    </h5>
                    <button
                        type="button"
                        @click="closeModal"
                        class="close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form @submit.prevent="soumettre" id="createForm">
                        <div class="form-group">
                            
                            <label for="">Nom entreprise</label>

                            <input 
                            type="text" 
                            class="form-control" 
                            v-model="nomEntreprise" 
                            :class="{'is-invalid': nomErreur != ''}" 
                            required>

                            <span v-if=" nomErreur != '' " class="invalid-feedback error"> {{ nomErreur }} </span>

                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-danger"
                        @click="closeModal"
                    >
                        Fermer
                    </button>
                    <button form="createForm" type="submit" class="btn btn-success">
                        Soumettre
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import {useSwalSuccess, useSwalError} from "../../Composables/alert";
import { sourceMapsEnabled } from 'process';

const nomEntreprise = ref("");
const nomErreur = ref("");
const soumettre = ()=> {
    const nom_entreprise = nomEntreprise.value;
    const url = route("entreprise.store");
    router.post(
        url,
        {nom_entreprise},
        {
            onSuccess: (page) => {
                closeModal();
                useSwalSuccess("Entreprise ajouté avec succès");

            },
            onError: (errors) => {
                if (errors.nom_entreprise != null) {
                    nomErreur.value = "Ce nom existe déjà"
                }
                useSwalError("Une erreur s'est produite, reessayer");

            }
        }
    );
};


    const closeModal = ()=> {
        $("#creerNouvelleEntrepriseModal").modal("hide");
        nomEntreprise.value = "";
    };
</script>