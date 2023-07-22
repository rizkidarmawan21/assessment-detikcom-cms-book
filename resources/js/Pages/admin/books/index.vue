<script>
export default {
    layout: AppLayout,
};
</script>
<script setup>
import axios from "axios";
import { notify } from "notiwind";
import { Inertia } from "@inertiajs/inertia";
import { object, string } from "vue-types";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import { ref, onMounted, reactive, computed } from "vue";
import AppLayout from "@/layouts/apps.vue";
import debounce from "@/composables/debounce";
import VDropdownEditMenu from "@/components/VDropdownEditMenu/index.vue";
import VDataTable from "@/components/VDataTable/index.vue";
import VPagination from "@/components/VPagination/index.vue";
import VBreadcrumb from "@/components/VBreadcrumb/index.vue";
import VLoading from "@/components/VLoading/index.vue";
import VEmpty from "@/components/src/icons/VEmpty.vue";
import VButton from "@/components/VButton/index.vue";
import VAlert from "@/components/VAlert/index.vue";
import VModalForm from "./ModalForm.vue";
import VFilter from './Filter.vue';

const userRole = computed(() => usePage().props.value.admin_role);
const query = ref([]);
const searchFilter = ref("");
const breadcrumb = [
    {
        name: "Dashboard",
        active: false,
        to: route("dashboard.index"), 
    },
    {
        name: "Book Management",
        active: false,
        to: "",
    },
];
const pagination = ref({
    count: "",
    current_page: 1,
    per_page: "",
    total: 0,
    total_pages: 1,
});
const alertData = reactive({
    headerLabel: "",
    contentLabel: "",
    closeLabel: "",
    submitLabel: "",
});

const itemSelected = ref({});
const updateAction = ref(false);
const openModalForm = ref(false);
const openAlert = ref(false);
const heads = [
    "No",
    "Cover",
    "File",
    "Title",
    "Category",
    "Description",
    "Number of Page",
    "",
];

// if userRole == super admin heads include author
if (userRole.value == "super admin") {
    heads.splice(3, 0, "Owner");
}
const isLoading = ref(true);

const props = defineProps({
    title: string(),
    additional: object(),
});

const getData = debounce(async (page) => {
    axios
        .get(route("books.get-data"), {
            params: {
                page: page,
                search: searchFilter.value,
            },
        })
        .then((res) => {
            query.value = res.data.data;
            pagination.value = res.data.meta.pagination;
        })
        .catch((res) => {
            notify(
                {
                    type: "error",
                    group: "top",
                    text: res.response.data.message,
                },
                2500
            );
        })
        .finally(() => (isLoading.value = false));
}, 500);

const nextPaginate = () => {
    pagination.value.current_page += 1;
    isLoading.value = true;
    getData(pagination.value.current_page);
};

const previousPaginate = () => {
    pagination.value.current_page -= 1;
    isLoading.value = true;
    getData(pagination.value.current_page);
};

const handleAddModalForm = () => {
    updateAction.value = false;
    openModalForm.value = true;
};

const handleEditModal = (data) => {
    updateAction.value = true;
    itemSelected.value = data;
    openModalForm.value = true;
};

const searchHandle = (search) => {
    searchFilter.value = search;
    isLoading.value = true;
    getData(1);
};

const closeModalForm = () => {
    itemSelected.value = ref({});
    openModalForm.value = false;
};

const successSubmit = () => {
    isLoading.value = true;
    getData(pagination.value.current_page);
};

const alertDelete = (data) => {
    itemSelected.value = data;
    openAlert.value = true;
    alertData.headerLabel = "Are you sure to delete this?";
    alertData.contentLabel = "You won't be able to revert this!";
    alertData.closeLabel = "Cancel";
    alertData.submitLabel = "Delete";
};

const closeAlert = () => {
    itemSelected.value = ref({});
    openAlert.value = false;
};

const deleteHandle = async () => {
    axios
        .delete(route("books.delete", { id: itemSelected.value.id }))
        .then((res) => {
            notify(
                {
                    type: "success",
                    group: "top",
                    text: res.data.meta.message,
                },
                2500
            );
            openAlert.value = false;
            isLoading.value = true;
            getData(pagination.value.current_page);
        })
        .catch((res) => {
            notify(
                {
                    type: "error",
                    group: "top",
                    text: res.response.data.message,
                },
                2500
            );
        });
};

onMounted(() => {
    getData(1);
});
</script>

<template>
    <Head :title="props.title" />
    <VBreadcrumb :routes="breadcrumb" />
    <div class="mb-4 sm:mb-6 flex justify-between items-center">
        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
            Book Management
        </h1>
    </div>
    <div
        class="bg-white shadow-lg rounded-sm border border-slate-200"
        :class="isLoading && 'min-h-[40vh] sm:min-h-[50vh]'"
    >
        <header class="block justify-between items-center sm:flex py-6 px-4">
            <h2 class="font-semibold text-slate-800">
                All Book
                <span class="text-slate-400 !font-medium ml">{{
                    pagination.total
                }}</span>
            </h2>
            <div
                class="mt-3 sm:mt-0 flex space-x-2 sm:justify-between justify-end"
            >
                <!-- Filter -->
                <VFilter @search="searchHandle" :additional="additional"/>
                <VButton
                    label="Add Book"
                    type="primary"
                    @click="handleAddModalForm"
                    class="mt-auto"
                />
            </div>
        </header>

        <VDataTable :heads="heads" :isLoading="isLoading">
            <tr v-if="isLoading">
                <td
                    class="h-[100%] overflow-hidden my-2"
                    :colspan="heads.length"
                >
                    <VLoading />
                </td>
            </tr>
            <tr v-else-if="query.length === 0 && !isLoading">
                <td class="overflow-hidden my-2" :colspan="heads.length">
                    <div class="flex items-center flex-col w-full my-32">
                        <VEmpty />
                        <div
                            class="mt-9 text-slate-500 text-xl md:text-xl font-medium"
                        >
                            Result not found.
                        </div>
                    </div>
                </td>
            </tr>
            <tr v-for="(data, index) in query" :key="index" v-else>
                <td class="p-4 whitespace-nowrap h-16">{{ index + 1 }}</td>
                <td class="p-4 whitespace-nowrap h-16">
                    <img :src="data.path + data.cover_file" class="h-20" alt="" />
                </td>
                <td class="p-4 whitespace-nowrap h-16 capitalize">
                    <a
                        v-if="data.pdf_file"
                        :href="data.path + data.pdf_file"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="bg-sky-400 text-white py-1 px-2 rounded-xl hover:bg-sky-500"
                        >Read a Book</a
                    >
                </td>
                <td
                    v-if="userRole[0] == 'super admin'"
                    class="p-4 whitespace-nowrap h-16 capitalize"
                >
                    {{ data.author }}
                </td>
                <td class="p-4 h-16 capitalize">
                    {{ data.title }}
                </td>
                <td class="p-4 whitespace-nowrap h-16 capitalize">
                    {{ data.category.name }}
                </td>
                <td class="p-4 h-16 capitalize">
                    {{ data.description }}
                </td>
                <td class="p-4 whitespace-nowrap h-16 capitalize">
                    {{ data.number_of_pages }}
                </td>
                <td class="p-4 whitespace-nowrap h-16 text-right">
                    <VDropdownEditMenu
                        class="relative inline-flex r-0"
                        :align="'right'"
                        :last="index === query.length - 1 ? true : false"
                    >
                        <li
                            class="cursor-pointer hover:bg-slate-100"
                            @click="handleEditModal(data)"
                        >
                            <div class="flex items-center space-x-2 p-3">
                                <span>
                                    <VEdit color="primary" />
                                </span>
                                <span>Edit</span>
                            </div>
                        </li>
                        <li class="cursor-pointer hover:bg-slate-100">
                            <div
                                class="flex justify-between items-center space-x-2 p-3"
                                @click="alertDelete(data)"
                            >
                                <span>
                                    <VTrash color="danger" />
                                </span>
                                <span>Delete</span>
                            </div>
                        </li>
                    </VDropdownEditMenu>
                </td>
            </tr>
        </VDataTable>
        <div class="px-4 py-6">
            <VPagination
                :pagination="pagination"
                @next="nextPaginate"
                @previous="previousPaginate"
            />
        </div>
    </div>
    <VAlert
        :open-dialog="openAlert"
        @closeAlert="closeAlert"
        @submitAlert="deleteHandle"
        type="danger"
        :headerLabel="alertData.headerLabel"
        :content-label="alertData.contentLabel"
        :close-label="alertData.closeLabel"
        :submit-label="alertData.submitLabel"
    />
    <VModalForm
        :data="itemSelected"
        :update-action="updateAction"
        :open-dialog="openModalForm"
        @close="closeModalForm"
        @successSubmit="successSubmit"
        :additional="additional"
    />
</template>
