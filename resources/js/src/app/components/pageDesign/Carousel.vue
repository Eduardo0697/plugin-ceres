<template>
    <div class="row">
        <div class="col-12 col-lg-12" v-if="$slots.items && $slots.items.length > itemsPerPage">
            <div class="list-item-carousel owl-carousel owl-theme owl-single-item" ref="carouselContainer">
                <slot-component v-for="(item, index) in $slots.items" :key="index" :vnode="item" />
            </div>
        </div>

        <div :class="columnWidths" v-else v-for="item in $slots.items">
            <slot-component :vnode="item"/>
        </div>
    </div>
</template>

<script>
import "owl.carousel";

export default {
    components: {
        SlotComponent: {
            functional: true,
            render: (createElement, context) => context.data.attrs.vnode
        }
    },

    props: {
        itemsPerPage: {
            type: Number,
            default: 4
        }
    },

    data()
    {
        return {
            isCarouselInitialized: false
        };
    },

    computed:
    {
        columnWidths()
        {
            const itemsPerPage = Math.min(Math.max(this.itemsPerPage, 1), 4);

            return [
                "col-12",
                itemsPerPage === 1 ? "col-sm-12" : "col-sm-6",
                "col-md-" + (12 / itemsPerPage)
            ];
        }
    },

    updated()
    {
        this.initializeCarousel();
    },

    mounted()
    {
        this.$nextTick(() =>
        {
            this.initializeCarousel();
        });
    },

    methods:
    {
        initializeCarousel()
        {
            if (this.$slots.items && this.$slots.items.length > this.itemsPerPage)
            {
                const $owl = $(this.$refs.carouselContainer);
    
                if (this.isCarouselInitialized)
                {
                    $owl.trigger("destroy.owl.carousel");
                    $owl.html($owl.find(".owl-stage-outer").html()).removeClass("owl-loaded");
                    $owl.find(".owl-item").remove();
                }

                // do not render, if no html element is inside of the carousels container
                if (!$owl.children().length)
                {
                    return;
                }
    
                this.isCarouselInitialized = true;
    
                $owl.owlCarousel({
                    autoHeight: true,
                    dots: true,
                    items: this.itemsPerPage,
                    responsive: {
                        0: {
                            items: 1
                        },
                        576: {
                            items: this.itemsPerPage > 1 ? 2 : 1
                        },
                        768: {
                            items: this.itemsPerPage > 3 ? 3 : this.itemsPerPage
                        },
                        992: {
                            items: this.itemsPerPage
                        }
                    },
                    lazyLoad: false,
                    loop: false,
                    margin: 30,
                    mouseDrag: true,
                    nav: true,
                    navClass: [
                        "owl-single-item-nav left carousel-control list-control-special",
                        "owl-single-item-nav right carousel-control list-control-special"
                    ],
                    navContainerClass: "",
                    navText: [
                        "<i class=\"owl-single-item-control fa fa-chevron-left\" aria-hidden=\"true\"></i>",
                        "<i class=\"owl-single-item-control fa fa-chevron-right\" aria-hidden=\"true\"></i>"
                    ],
                    smartSpeed: 350
                });
            }
        }
    }
}
</script>
