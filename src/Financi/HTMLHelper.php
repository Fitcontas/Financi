<?php

namespace Financi;

/**
 * HTMLHelper, estou criando esta classe para ajudar na composição de alguns formulários
 */
class HTMLHelper
{   
    static $form_fields;

    static $block;

    static $block_input_group;

    static function renderRow($row) 
    {

        self::$block = [
                        'default'=>'<div class="%s">
                        <div class="form-group">
                                    <label>%s</label> 
                                    <input type="text" class="form-control" name="%s" id="%s" value="%s" %s %s>
                                </div></div>',
                        'default-with-hidden'=>'<div class="%s">
                        <div class="form-group">
                                    <label>%s</label> 
                                    <input type="text" class="form-control" name="%s" id="%s" value="%s" %s %s>
                                    %s
                                </div></div>',
                        'input-group' => '<div class="%s">
                        <div class="form-group">
                                        <label>%s</label> 
                                        <div class="input-group date">
                                            <input type="text" class="form-control %s" name="%s" id="%s" value="%s" %s %s>
                                            %s
                                        </div>
                                  </div></div>',
                        'input-group-datepicker' => '<div class="%s">
                        <div class="form-group">
                                        <label>%s</label> 
                                        <div class="input-group date">
                                            <input type="text" class="form-control %s" name="%s" id="%s" value="%s" %s %s>
                                            <span class="add-on input-group-btn"><button class="btn btn-default" type="button" tabindex="2"><i class="fa fa-calendar" title="Calendário"></i></button></span>
                                        </div>
                                  </div></div>',
                        'input-group-buttom' => '<div class="%s">
                        <div class="form-group">
                                        <label>%s</label> 
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="%s" id="%s" value="%s" %s %s>
                                            <span class="input-group-btn">
                                            <button title="" type="button" name="" class="btn btn-default btn-%s">%s</button>
                                            </span>
                                        </div>
                                  </div></div>',
                        'default-select'=>'<div class="%s">
                        <div class="form-group">
                                    <label>%s</label> 
                                    <select class="form-control" name="%s" id="%s" %s %s>
                                        %s
                                    </select>
                                </div></div>',
                        'select-ng-repeat' => '<div class="%s">
                        <div class="form-group">
                                                    <label>%s</label> 
                                                    <select class="form-control" name="%s" id="%s" %s %s>
                                                        %s
                                                    </select>
                                                </div></div>'
                    ];  

        self::$form_fields = $row;

        /**[
            [
                'field_type' => 'input',
                'label' => 'CPF',
                'name' => 'cpf',
                'id' => 'cpf',
                'label_type' => 'block',
                'block_class' => 'col-lg-3',
                'default_value' => '04788373564'
            ]
        ];*/

        $html = '<div class="row hpadding">
';
        
        foreach (self::$form_fields as $field) {
            $html .= self::renderField($field);
        }

        $html .= '</div>';
        echo $html;
    }

    static function renderField($field)
    {
        $label = isset($field['label']) ? $field['label'] : 'Sem label';
        $name = isset($field['name']) ? $field['name'] : strtolower($label);
        $class = isset($field['class']) ? $field['class'] : '';
        $id = isset($field['id']) ? $field['id'] : $name;
        $block_class = isset($field['block_class']) ? $field['block_class'] : 'col-lg-6';
        $block = isset($field['block']) ? $field['block'] : 'default';
        $value = isset($field['value']) ? $field['value'] : '';
        $options = isset($field['options']) ? $field['options'] : [];
        $input_group_symbol = isset($field['input_group_symbol']) ? $field['input_group_symbol'] : '?';
        $input_group_btn_class = isset($field['input_group_btn_class']) ? $field['input_group_btn_class'] : 'add';
        $attributes = isset($field['attributes']) ? $field['attributes'] : '';
        $ng_model = isset($field['ng-model']) ? 'ng-model="' . $field['ng-model'] . '"' : '';
        $ng_option = isset($field['ng-option']) ? $field['ng-option'] : '';
        $hidden = isset($field['hidden']) ? $field['hidden'] : '';

        if($block == 'default-select') {
            return sprintf(self::$block[$block], $block_class, $label, $name, $id,  $ng_model, $attributes, self::renderSelectOption($value, $options));
        }

        if($block == 'select-ng-repeat') {
            return sprintf(self::$block[$block], $block_class, $label, $name, $id,  $ng_model, $attributes, $ng_option);
        }

        if($block == 'input-group') {
            return sprintf(self::$block[$block], $block_class, $label, $class, $name, $id, $value, $ng_model, $attributes, $input_group_symbol);
        }

         if($block == 'input-group-datepicker') {
            return sprintf(self::$block[$block], $block_class, $label, $class, $name, $id, $value, $ng_model, $attributes);
        }

        if($block == 'input-group-buttom') {
            return sprintf(self::$block[$block], $block_class, $label, $name, $id, $value, $ng_model, $attributes, $input_group_btn_class, $input_group_symbol);
        }

        if($block == 'default-with-hidden') {
            return sprintf(self::$block[$block], $block_class, $label, $name, $id, $value, $attributes, $ng_model, $hidden);
        }

        return sprintf(self::$block[$block], $block_class, $label, $name, $id, $value, $attributes, $ng_model);
    }

    static function renderSelectOption($value, $options)
    {
        $html_select_options = '<option value=""></option>';
        foreach ($options as $key => $option_value) {
            $selected = ($value == $option_value) ? 'selected' : '';
            $html_select_options .= '<option ' . $selected . ' value="' . $key . '">' . $option_value . '</option>';
        }

        return $html_select_options;
    }
}