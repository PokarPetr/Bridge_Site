import $ from 'jquery';

class Like {
    constructor() {
     this.events();
    }

    events() {
        $(".like-box").on('click', this.our_click_dispatcher.bind(this));
    }

    //Methods
    our_click_dispatcher(e) {
        var current_like_box = $(e.target).closest(".like-box");

        if (current_like_box.attr("data-exists") == "yes") {
            this.delete_like(current_like_box);
        } else {
            this.create_like(current_like_box);
        }
    }
    create_like(current_like_box) {
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', bridge_data.nonce);
            },
            url: bridge_data.root_url + '/wp-json/bridge/v1/manage_like',
            type: 'POST',
            data: {'leader_id': current_like_box.data('player')},
            success: (response) => {
                current_like_box.attr('data-exists', 'yes');
                var like_count = parseInt(current_like_box.find('.like-count').html(), 10);                
                like_count++;                
                current_like_box.find('.like-count').html(like_count); 
                current_like_box.attr('data-like', response);                
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            }
        });
    }
    delete_like(current_like_box) {
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', bridge_data.nonce);
            },
            url: bridge_data.root_url + '/wp-json/bridge/v1/manage_like',
            data: {'like': current_like_box.attr('data-like')},
            type: 'DELETE',
            success: (response) => {
                current_like_box.attr('data-exists', 'no');
                var like_count = parseInt(current_like_box.find('.like-count').html(), 10);                
                like_count--;                
                current_like_box.find('.like-count').html(like_count); 
                current_like_box.attr('data-like', '');
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            }
        });
    }
}

export default Like
