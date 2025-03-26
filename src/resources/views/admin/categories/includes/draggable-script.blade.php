@push("scripts")
    <script type="application/javascript">
        document.addEventListener('livewire:initialized', () => {
            initDraggable()

            Livewire.on('re-init-script', () => {
                setTimeout(() => {
                    initDraggable()
                }, 500)
            })
        })

        let root = document.querySelector("[drag-category-root]")
        root.send = false

        function initDraggable() {
            root.addEventListener("mouseleave", rootMouseleave)

            root.querySelectorAll("[drag-category-grab]").forEach(el => {
                el.removeEventListener("mouseover", grabMouseOver)
                el.addEventListener("mouseover", grabMouseOver)

                el.removeEventListener("mouseleave", grabMouseLeave)
                el.addEventListener("mouseleave", grabMouseLeave)
            })

            root.querySelectorAll("[drag-category-item]").forEach(el => {
                el.counter = 0
                el.removeEventListener('dragstart', itemDragStart)
                el.addEventListener('dragstart', itemDragStart)

                el.removeEventListener('dragend', itemDragEnd)
                el.addEventListener('dragend', itemDragEnd)

                el.removeEventListener('dragleave', itemDragLeave)
                el.addEventListener('dragleave', itemDragLeave)

                el.removeEventListener('dragenter', itemDragEnter)
                el.addEventListener('dragenter', itemDragEnter)

                el.removeEventListener('dragover', itemDragOver)
                el.addEventListener('dragover', itemDragOver)

                el.removeEventListener('drop', itemDrop)
                el.addEventListener('drop', itemDrop)
            })
        }

        function rootMouseleave() {
            clearAll(root, true)
        }

        function grabMouseOver(e) {
            e.target.closest("[drag-category-item]").setAttribute("draggable", true)
        }

        function itemDragStart(e) {
            root.send = false
            root.querySelectorAll("[drag-category-item]").forEach(innerEl => {
                innerEl.counter = 0
            })
            root.querySelectorAll("[drag-category-empty]").forEach(emptyEl => {
                emptyEl.classList.remove("hidden")
            })
            e.target.setAttribute('dragging', true)
        }

        function itemDragEnd(e) {
            e.target.removeAttribute('dragging')
        }

        function itemDragLeave(e) {
            e.target.counter--
            e.target.querySelectorAll("[drag-category-item]").forEach(item => {
                item.counter--
            })

            if (e.target.counter <= 0)
                e.target.closest("[drag-category-item]").querySelectorAll("[drag-category-data]").forEach(data => {
                    data.classList.remove('opacity-50')
                })
        }

        function itemDragEnter(e) {
            clearAll(root)
            e.target.counter++

            e.target.closest("[drag-category-item]").querySelectorAll("[drag-category-data]").forEach(data => {
                data.closest("[drag-category-item]").counter++
                data.classList.add("opacity-50")
            })
            e.preventDefault()
        }

        function itemDragOver(e) {
            e.preventDefault()
        }

        function itemDrop(e) {
            if (root.send) return
            clearAll(root, true)

            let draggingEl = root.querySelector('[dragging]')
            let chosenEl = e.target.closest('[drag-category-item]')

            if (draggingEl.getAttribute('drag-category-item') === chosenEl.getAttribute('drag-category-item')) return

            if (e.target.hasAttribute('drag-category-empty')) {
                if (e.target.closest('[drag-category-parent]').getAttribute('drag-category-item') === draggingEl.getAttribute('drag-category-item')) return
                e.target.closest('[drag-category-parent]').append(draggingEl)
            } else {
                if (draggingEl.getAttribute('drag-category-item-parent') === chosenEl.getAttribute('drag-category-item-parent')) {
                    if (draggingEl.getAttribute('drag-category-item-order') > chosenEl.getAttribute('drag-category-item-order')) {
                        chosenEl.before(draggingEl)
                    } else {
                        chosenEl.after(draggingEl)
                    }
                } else {
                    chosenEl.after(draggingEl)
                }
            }

            let component = Livewire.find(
                root.closest('[wire\\:id]').getAttribute('wire:id')
            )
            let result = parseChildren(root.querySelector(':scope > [drag-category-parent]'))
            component.call('tmpOrder', result)

            root.send = true
        }

        function grabMouseLeave(e) {
            e.target.closest("[drag-category-item]").removeAttribute("draggable")
        }

        function parseChildren(parent) {
            if (! parent) return []
            let tree = []
            parent.querySelectorAll(':scope > [drag-category-item]').forEach(child => {
                if (child.hasAttribute('drag-category-item-ignore')) return
                let item = {}
                item.id = child.getAttribute('drag-category-item')
                item.children = parseChildren(child.querySelector(':scope > [drag-category-parent]'))
                tree.push(item)
            })
            return tree
        }

        function clearAll(root, counter = false) {
            if (counter) {
                root.querySelectorAll("[drag-category-empty]").forEach(emptyEl => {
                    emptyEl.classList.add("hidden")
                })
                root.querySelectorAll("[drag-category-item]").forEach(item => {
                    item.counter = 0
                })
            }

            root.querySelectorAll("[drag-category-item]").forEach(item => {
                item.querySelectorAll("[drag-category-data]").forEach(data => {
                    data.classList.remove('opacity-50')
                })
            })
        }
    </script>
@endpush
