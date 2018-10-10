<template>
    <div class="row justify-content-center">
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item" :class="{disabled: pagination.current_page <= 1}" @click.prevent="changePage(1)">
                    <a class="page-link" href="#">First page</a>
                </li>
                <li class="page-item" :class="{disabled: pagination.current_page <= 1}" @click.prevent="changePage(pagination.current_page - 1)">
                    <a class="page-link" href="#">Previous</a>
                </li>
                <template v-for="page in pages">
                    <li class="page-item" :class="isCurrentPage(page) ? 'active' : ''"  @click.prevent="changePage(page)">
                        <a class="page-link" href="#" >{{ page }} <span v-if="isCurrentPage(page)" class="sr-only">(current)</span></a>
                    </li>
                </template>

                <li class="page-item" :class="{disabled: pagination.current_page >= pagination.last_page}" @click.prevent="changePage(pagination.last_page)">
                    <a class="page-link" href="#">Next page</a>
                </li>
                <li class="page-item" :class="{disabled: pagination.current_page >= pagination.last_page}" @click.prevent="changePage(pagination.last_page)">
                    <a class="page-link" href="#">Last page</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<style>
    .pagination {
        margin-top: 40px;
    }
</style>

<script>
    export default {
        props: ['pagination', 'offset'],
        methods: {
            isCurrentPage(page) {
                return this.pagination.current_page === page;
            },
            changePage(page) {
                if (page > this.pagination.last_page) {
                    page = this.pagination.last_page;
                }
                this.pagination.current_page = page;
                this.$emit('paginate');
            }
        },
        computed: {
            pages() {
                let pages = [];
                let from = this.pagination.current_page - Math.floor(this.offset / 2);
                if (from < 1) {
                    from = 1;
                }
                let to = from + this.offset - 1;
                if (to > this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                while (from <= to) {
                    pages.push(from);
                    from++;
                }
                return pages;
            }
        }
    }
</script>
