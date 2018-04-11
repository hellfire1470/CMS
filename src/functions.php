<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function add_header($html) {
    LayoutManager::AddToLayer('header', $html);
}

function get_header() {
    return LayoutManager::GetAllHeaderContent();
}
