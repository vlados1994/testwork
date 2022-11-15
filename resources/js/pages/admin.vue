<template>
    <div class="container">
        <div class="row justify-content-center admin">
            <div class="admin__title">
                Админ-панель
            </div>
            <div class="admin__container">
                <div class="admin__table-container">
                    <div class="admin__table-title">
                        Пользователи
                    </div>
                    <div class="admin__table-headers">
                        <v-row no-gutters>
                            <v-col cols="1" sm="1">
                                <v-sheet class="ma-2 pa-2">
                                    id
                                </v-sheet>
                            </v-col>
                            <v-col cols="2" sm="2">
                                <v-sheet class="ma-2 pa-2">
                                    Имя
                                </v-sheet>
                            </v-col>
                            <v-col cols="3" sm="3">
                                <v-sheet class="ma-2 pa-2">
                                    Почта
                                </v-sheet>
                            </v-col>
                            <v-col cols="2" sm="2">
                                <v-sheet class="ma-2 pa-2">
                                    Тип
                                </v-sheet>
                            </v-col>
                            <v-col cols="3" sm="3">
                                <v-sheet class="ma-2 pa-2">

                                </v-sheet>
                            </v-col>
                        </v-row>
                    </div>
                    <div class="admin__users">
                        <v-row
                            v-for="user in users"
                            no-gutters
                        >
                            <v-col cols="1" sm="1">
                                <v-sheet class="ma-2 pa-2">
                                    {{ user.id }}
                                </v-sheet>
                            </v-col>
                            <v-col cols="2" sm="2">
                                <v-sheet class="ma-2 pa-2">
                                    {{ user.name }}
                                </v-sheet>
                            </v-col>
                            <v-col cols="3" sm="3">
                                <v-sheet class="ma-2 pa-2">
                                    {{ user.email }}
                                </v-sheet>
                            </v-col>
                            <v-col cols="2" sm="2">
                                <v-sheet class="ma-2 pa-2">
                                    {{ translations[user.type] }}
                                </v-sheet>
                            </v-col>
                            <v-col cols="3" sm="3">
                                <v-sheet class="ma-2 pa-2">
                                    <v-btn
                                        variant="flat"
                                        color="error"
                                        @click="deleteUser(user.id)"
                                    >
                                        Удалить
                                    </v-btn>
                                </v-sheet>
                            </v-col>
                        </v-row>
                    </div>
                </div>
                <div class="admin__table-container">
                    <div class="admin__table-title">
                        Услуги
                    </div>
                    <div class="admin__table-headers">
                        <v-row no-gutters>
                            <v-col cols="1" sm="1">
                                <v-sheet class="ma-2 pa-2">
                                    id
                                </v-sheet>
                            </v-col>
                            <v-col cols="2" sm="2">
                                <v-sheet class="ma-2 pa-2">
                                    Имя
                                </v-sheet>
                            </v-col>
                        </v-row>
                    </div>
                    <div class="admin__services">
                        <v-row
                            v-for="service in services"
                            no-gutters
                        >
                            <v-col cols="1" sm="1">
                                <v-sheet class="ma-2 pa-2">
                                    {{ service.id }}
                                </v-sheet>
                            </v-col>
                            <v-col cols="2" sm="2">
                                <v-sheet class="ma-2 pa-2">
                                    {{ service.name }}
                                </v-sheet>
                            </v-col>
                        </v-row>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        users: [],
        translations: {
            'user': 'Пользователь',
            'dentist': 'Дантист',
        },
        services: [],
    }),
    methods: {
        async deleteUser(id) {
            const response = await axios.delete('/api/users/' + id, {});

            await this.getUsers();
        },
        async getUsers() {
            const response = await axios.get('/api/users', {});

            this.users = response.data.data;
        },
        async getServices() {
            const response = await axios.get('/api/services', {});

            this.services = response.data.data;

            console.log('this.services', this.services);
        }
    },
    async mounted() {
        await this.getUsers();
        await this.getServices();
    },
}
</script>

<style>
.admin {
    flex-direction: column;
    align-items: center;
}

.admin__title {
    width: auto;
    font-weight: bold;
    font-size: 20px;
    margin-top: 50px;
}

.admin__container {
    display: flex;
    margin-top: 30px;
}

.admin__users {
    width: 800px;
}

.admin__services {
    width: 800px;
}

.admin__table-container {
    display: flex;
    flex-direction: column;
}

.admin__table-headers {
    width: 800px;
}

.admin__table-title {
    width: auto;
    font-weight: bold;
    font-size: 20px;
    margin-top: 50px;
    margin-left: 20px;
}

</style>
