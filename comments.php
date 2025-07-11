<?php
/**
 * The template for displaying comments.
 */
if (post_password_required()) {
    return;
}
?>
<!-- BEGIN of comments -->
<div id="comments" class="comments-area">
    <?php if (have_comments()) { ?>
        <h3 class="comments-title">
            <?php $comments_number = get_comments_number(); ?>
            <?php if (1 == $comments_number) {
                _e('1 comment', 'fwp');
            } else {
                printf(__('%s comments', 'fwp'), $comments_number);
            } ?>
        </h3>

        <?php the_comments_navigation(); ?>

        <ol class="comment-list">
            <?php wp_list_comments([
                'style' => 'ol',
                'short_ping' => true,
                'avatar_size' => 42,
            ]); ?>
        </ol>

        <?php the_comments_navigation(); ?>
    <?php } // Check for have_comments().?>

    <?php
    // If comments are closed and there are comments, let's leave a little note, shall we?
    if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) { ?>
        <p class="no-comments"><?php _e('Comments are closed.', 'fwp'); ?></p>
    <?php } ?>

    <?php comment_form([
        'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
        'title_reply_after' => '</h3>',
        'class_submit' => 'submit button',
    ]); ?>
</div>
<!-- END of comments -->
