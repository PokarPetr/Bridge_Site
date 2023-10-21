wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
    title: "Are You Paying Attenton?",
    icon: "smiley",
    category: "common",
    edit: function () {
        return wp.element.createElement("h3", null, "Hello from an admin editor screen")
    },
    save: function () {
        return wp.element.createElement("h1", null, "This is the frontend")

    }
    
})