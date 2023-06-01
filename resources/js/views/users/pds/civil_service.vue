<template>
    <div>
        <div class="col table-responsive" id="no-more-tables">
            <table class="table table-hover table-striped smnall table-sm">
                <thead>
                    <tr class="table-light">
                        <th class="numeric" width="30%">Eligibility</th>
                        <th class="numeric" width="5%">Rating</th>
                        <th class="numeric" width="5%">Date</th>
                        <th class="numeric" width="30%">Place of Exam</th>
                        <th class="numeric" width="15%">License No.</th>
                        <th class="numeric" width="5%">Date Valid</th>
                        <th class="numeric"></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr v-for="civil in pageOfItems" :key="civil.id">
                        <td>{{ civil.pds_civil_service[0].CSCareer }}</td>
                        <td>{{ civil.pds_civil_service[0].CSRating }}</td>
                        <td>{{ civil.pds_civil_service[0].CSDate }}</td>
                        <td>{{ civil.pds_civil_service[0].CSPlaceExam }}</td>
                        <td>{{ civil.pds_civil_service[0].CSnumber }}</td>
                        <td>{{ civil.pds_civil_service[0].CSDateValid }}</td>
                        <td>
                            <button
                                @click="
                                    editCivil(civil.pds_civil_service[0].id)
                                "
                                class="btn btn-warning btn-sm  text-white"
                            >
                                <i
                                    class="fa fa-pencil text-white"
                                    aria-hidden="true"
                                ></i>
                            </button>
                            <button
                                @click="
                                    viewDocument(
                                        civil.pds_civil_service[0].document
                                    )
                                "
                                v-if="civil.pds_civil_service[0].document"
                                class="btn btn-dark btn-sm"
                            >
                                <i class="fa-solid fa-eye"></i>
                            </button>

                            <button
                                @click="
                                    deleteCivil(civil.pds_civil_service[0].id)
                                "
                                class="btn btn-danger btn-sm text-white"
                            >
                                <i
                                    class="fa fa-trash text-white"
                                    aria-hidden="true"
                                ></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col text-center">
                <jw-pagination
                    :items="sortedData"
                    :labels="customLabels"
                    @changePage="onChangePage"
                ></jw-pagination>
            </div>
        </div>
    </div>
</template>
<script>
const customLabels = {
    first: "<<",
    last: ">>",
    previous: "<",
    next: ">",
};
export default {
    data() {
        return {
            appData: [],
            sortedData: [],
            selected: [],
            pageOfItems: [],
            customLabels,
            user: [],
        };
    },
    methods: {
        async getData() {
            await axios.get("/getUserPds").then((response) => {
                this.sortedData = response.data.user_pds;
            });
        },
        getUser() {
            axios.get("/getUser").then((response) => {
                this.user = response.data;
            });
        },
        viewDocument(document) {
            window.location.href = "/storage/pdsFiles/" + document;
        },
        editCivil(id) {
            if (confirm("Are you Sure?")) {
                window.location.href =
                    "/users/pds/civilservice/" + id + "/edit";
            }
        },
        deleteCivil(id) {
            if (confirm("Are you Sure?")) {
                axios
                    .delete("/users/pds/civilservice/" + id)
                    .then((response) => {
                        window.location.href = "/users/pds/civilservice";
                    });
            }
        },
        onChangePage(pageOfItems) {
            // update page of items
            this.pageOfItems = pageOfItems;
        },
    },
    created() {
        this.getUser();
        this.getData();
    },
};
</script>
