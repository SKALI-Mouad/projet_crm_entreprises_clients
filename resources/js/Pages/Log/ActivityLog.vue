<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Historique des activités</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <Pagination
                            :links="props.logs.links"
                            :prev="props.logs.prev_page_url"
                            :next="props.logs.next_page_url"
                        />
                    </div>
                </div>

                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <!--<th style="width: 10px">#</th>-->
                                <th>
                                    <p>Date et Heure</p>
                                </th>
                                <th>
                                    <p>Nom admin</p>
                                </th>
                                <th>
                                    <p>Nom employé</p>
                                </th>
                                <th>
                                    <p>Description</p>
                                </th>
                                <!--<th>Progress</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="log in props.logs.data">
                                <td>{{ log.time }}</td>
                                <td>{{ log.nom_admin }}</td>
                                <td>{{ log.nom_employe }}</td>
                                <td>{{ log.description }}</td>
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
        logs: Object
    })

</script>
