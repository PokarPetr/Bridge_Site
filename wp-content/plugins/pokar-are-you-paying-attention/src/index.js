import "./index.scss"
import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon, PanelBody, PanelRow, ColorPicker} from "@wordpress/components"
import {InspectorControls, BlockControls, AlignmentToolbar} from "@wordpress/block-editor"
// Кастомный пикер с сайта casesandberg.github.io/react-color/
import {ChromePicker} from "react-color"


// Хотим сделать недоступным кнопку Update если не назначен правильный ответ
(function() {
    let locked = false
    /* Подписываемся на изменения данных в состоянии и определяем results == true, 
        если изменения в нашем блоке и мы не определили правильный ответ(correct_answer вместо индекса равен undefined)
        
    */
    wp.data.subscribe(function() {
      const results = wp.data.select("core/block-editor").getBlocks().filter(function(block) {
        return block.name == "ourplugin/are-you-paying-attention" && block.attributes.correct_answer == undefined
      })
  
      if (results.length && locked == false) {
        locked = true
        // Запрещаем в блоке редактора сохранять изменения. wp.data.dispatch используется для отправки действий (actions) к хранилищу данных
        wp.data.dispatch("core/editor").lockPostSaving("noanswer")
      }
  
      if (!results.length && locked) {
        locked = false
        // Разрешаем в блоке редактора сохранять изменения
        wp.data.dispatch("core/editor").unlockPostSaving("noanswer")
      }
    })
  })()

/* Регистрируем блок
    title, icon - отобращение блока при редактировании поста, example - превью в блоке
    attributes - поля ввода значений в блоке,
    edit - функция отображения при редактировании,
    save - то как отображается на странице в браузере(в данном случае отображение отдано в PHP файл),
    deprecated - чтобы можно было редактировать save и не иметь проблем в блоке редактирования. Оставленно в комментах для демонстрации вместе с первоначальным блоком save
*/
const attr = {
    question: {type: "srting"},
    answers: {type: "array", default: [""]},
    correct_answer: {type: "number", default: undefined},
    bg_color: {type: "string", default: "#ebebeb"},  
    the_alignment: {type: "string", default: "left"},  
};

wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
    title: "Are You Paying Attenton?",
    icon: "smiley",
    category: "common",
    attributes: attr,
    description: "Give your audience a chance to prove their comprehension.",
    example: {
        attributes: {
            question: "What is my name",
            correct_answer: 3,
            answers: ["Ira", "Viktor", "Elisey"],
            bg_color: "#ebebeb",
            the_alignment: "center"
        }
    },
    edit: EditComponent,
    // Функция save возвращает null, так как мы хотим всё логику фронтенда определять в index.php
    save: function (props) {
        return null
    }
})

function EditComponent(props) {    
    function update_question(value) {
        props.setAttributes({question: value})
    }
    // Функция удаления поля с ответом в дашборде при клик на Delete-button
    function delete_answer(index_to_delete) {
        const new_answers = props.attributes.answers.filter(function(x, index) {
            return index != index_to_delete            
        })
        props.setAttributes({answers: new_answers})

        if (index_to_delete == props.attributes.correct_answer) {
            props.setAttributes({correct_answer: undefined});
        } else if(index_to_delete < props.attributes.correct_answer) {
            props.setAttributes({
                correct_answer: props.attributes.correct_answer - 1
            }); // else if корректирует индекс правильного ответа, если индекс удаляемого ответа был меньше индекса правильного ответа
        }
    }
    // Функция маркировки верного ответа при клике на иконку со звездой
    function mark_as_correct(index_to_mark) {        
        props.setAttributes({correct_answer: index_to_mark})
    }
    // Отображение блока в дашборде при редактировании поста  
    return (
        <div className="paying-attention-edit-block" style={{backgroundColor: props.attributes.bg_color}}>
            <BlockControls>
                <AlignmentToolbar value={props.attributes.the_alignment} onChange={x => props.setAttributes({the_alignment: x})}/>
            </BlockControls>
            <InspectorControls>
                <PanelBody title="Background Color" initialOpen={true}>
                    <PanelRow>
                        <ChromePicker color={props.attributes.bg_color} onChangeComplete={x => props.setAttributes({bg_color: x.hex})} disableAlpha={true}/>
                    </PanelRow>
                </PanelBody>
            </InspectorControls>
            <TextControl label="Quetion:" value={props.attributes.question} onChange={update_question} style={{fontSize: "20px"}}/>
            <p style={{fontSize: "13px", margin: "20px 0 8px 0"}}>Answers:</p>
            {props.attributes.answers.map(function (answer, index) {
                return (
                    <Flex>
                <FlexBlock>
                    <TextControl autoFocus={true} value={answer} onChange={new_value => {
                        const new_answers = props.attributes.answers.concat([])
                        new_answers[index] = new_value
                        props.setAttributes({answers: new_answers})
                    }}/>
                </FlexBlock>
                <FlexItem>
                    <Button onClick={() => mark_as_correct(index)}>
                        <Icon className="mark-as-correct" icon={props.attributes.correct_answer == index ? "star-filled" : "star-empty"} />
                    </Button>
                </FlexItem>
                <FlexItem>
                    <Button variant="link" className="attention-delete" onClick={() => delete_answer(index)}>Delete</Button>
                </FlexItem>
            </Flex>
                )
            })}
            
            <Button variant="primary" onClick={() => {
                props.setAttributes({answers: props.attributes.answers.concat([""])})
            }}>Add another answer</Button>
            <span className="paying-attention-message">Do not forget to chose the correct answer before Update</span>
            
        </div>
    )
}
