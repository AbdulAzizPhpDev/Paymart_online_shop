const ProductCard = {
    props: ['products'],
    data: () => ({
        count: 0,
    }),
    created() {
        console.log(this.products)
    },
    template: `
        <div>
            {{ count }}
            <button @click="count++">increment +1</button>
            <button @click="count--">decrement -1</button>
        </div>  
    `
    // render(createElement) {
    //     return createElement('div', `Hello world count: ${count}`)
    // },
}