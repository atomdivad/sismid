<template id="template">
    <table class="table table-responsive table-bordered table-striped">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Município</th>
            <th colspan="2">UF</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="i in lista[page]">
            <td>@{{ i.nome }}</td>
            <td>@{{ i.nomeCidade }}</td>
            <td>@{{ i.uf }}</td>
            <td><button class="btn btn-sm btn-primary" v-on:click="adicionarItem($event, $index)"><i class="glyphicon glyphicon-plus-sign"></i></button></td>
        </tr>
        </tbody>
    </table>
    <nav>
        <ul class="pager">
            <li v-bind:class="{ 'disabled': page == 0}"><a href="#" @click="doPrevious">Anterior</a></li>
            <li v-bind:class="{ 'disabled': page >= lista.length-1}"><a href="#" @click="doNext">Próximo</a></li>
        </ul>
    </nav>
</template>