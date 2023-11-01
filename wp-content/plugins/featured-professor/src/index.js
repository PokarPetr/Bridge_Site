import "./index.scss"
import { useSelect } from "@wordpress/data"
import {useState, useEffect} from "react"
import apiFetch from "@wordpress/api-fetch"
const __ = wp.i18n.__

const attrs = {
  prof_id:{type: 'string'}
}

wp.blocks.registerBlockType("ourplugin/featured-professor", {
  title: "Professor Callout",
  description: "Include a short description and link to a professor of your choice",
  icon: "welcome-learn-more",
  category: "common",
  attributes: attrs,
  edit: EditComponent,
  // save возвращает null и мы можем отдать отображение страницы коду PHP
  save: function () {
    return null
  }
})

// Отображаем вид в разделе редактирования постов
function EditComponent(props) {
  const [thePreview, setThePreview] = useState("")

  useEffect(() => {
    if (props.attributes.prof_id) {
      update_the_meta()
    async function go() {
      const res = await apiFetch({
        path: `featured_professor/v1/getHTML?prof_id=${props.attributes.prof_id}`,
        method: "GET"
      })
      setThePreview(res)      
    }
    go()
    }
  }, [props.attributes.prof_id])

  useEffect(() => {
    return () => {update_the_meta()}
  }, [])
  /*
      wp.data.select("core/block-editor"):
      wp.data - объект, предоставляющий доступ к глобальному хранилищу данных в WordPress.
      .select("core/block-editor") - метод выбора раздела "core/block-editor" в хранилище данных, связанного с блок-редактором.
      .getBlocks()- метод возвращает массив всех блоков, добавленных на страницу в текущем редакторе.
      .filter(x => x.name == "ourplugin/featured-professor") - код оставляет только те блоки, у которых имя (name) совпадает с "ourplugin/featured-professor". 
      .map(x => x.attributes.prof_id) - оставляет только атрибут с именем prof_id
      .filter((x, index, arr) => {
      return arr.indexOf(x) == index
      }) - удаляет дубликаты из массива
      В итоге в массиве profs_for_meta будут только свойства prof_id.

      Обновление метаданных поста. 
      wp.data.dispatch("core/editor"): Выбирает диспетчер для работы с редактором блоков.
      .editPost({meta: {featured_professor: profs_for_meta}}): 
      Обновляет метаданные текущего поста. Устанавливает мета-ключ featured_professor с массивом profs_for_meta в качестве его значения
  */
  function update_the_meta() {
    const profs_for_meta = wp.data.select("core/block-editor")
    .getBlocks()
    .filter(x => x.name == "ourplugin/featured-professor")
    .map(x => x.attributes.prof_id)
    .filter((x, index, arr) => {
      return arr.indexOf(x) == index
    })
    console.log(profs_for_meta)
    wp.data.dispatch("core/editor").editPost({meta: {featured_professor: profs_for_meta}})
  }

  // Получаем данные от базы данных wordpress и сохраняем массив в переменную all_profs
  const all_profs = useSelect(select => {
    return select("core").getEntityRecords("postType", "leader", {per_page: -1})
  })  
  // Пока загружаются данные выводим Loading...
  if (all_profs == undefined) return <p><strong>Loading...</strong></p>
  // После загрузки отображаем блок 
  return (
    <div className="featured-professor-wrapper">
      <div className="professor-select-container">
        <select onChange={e => props.setAttributes({prof_id: e.target.value})}>
          <option value="">{__('Select a player', 'featured-professor')}</option>
          {/*  Пробегаем по массиву с помощью map() */}
          {all_profs.map(prof => {
            return (
              <option value={prof.id} selected={props.attributes.prof_id == prof.id}>
                {prof.title.rendered}
                </option>
            )
          })}
        </select>
      </div>
      <div dangerouslySetInnerHTML={{__html: thePreview}}></div>
    </div>
  )
}