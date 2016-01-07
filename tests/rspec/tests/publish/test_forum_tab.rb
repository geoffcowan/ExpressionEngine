require './bootstrap.rb'

feature 'Forum Tab' do
  before :each do
    cp_session
    @page = Publish.new
    @page.forum_tab.install_forum
    @page.load
    no_php_js_errors
  end

  it 'has a forum tab' do
    @page.tab_links[4].text.should include 'Forum'
    @page.tab_links[4].click
    @page.forum_tab.should have_forum_title
    @page.forum_tab.should have_forum_body
    @page.forum_tab.should have_forum_id
    @page.forum_tab.should have_forum_topic_id
  end

  it 'associates a channel entry with a forum post when specifying a forum topic ID'
  it 'creates a forum post when entering data into the forum tab' do
    title = 'Forum Tab Test'
    body = 'Test content. Lorem ipsum dolor sit amet...'

    @page.title.set title
    @page.tab_links[4].click
    @page.forum_tab.forum_title.set title
    @page.forum_tab.forum_body.set body
    @page.submit

    @page.all_there?.should == false
    @page.alert.has_content?("The entry #{title} has been created.").should == true

    $db.query('SELECT title, body FROM exp_forum_topics').each do |row|
      row['title'].should == title
      row['body'].should == body
    end

    $db.query('SELECT forum_topic_id FROM exp_channel_titles ORDER BY entry_id desc LIMIT 1').each do |row|
      row['forum_topic_id'].should == 1
    end
  end

  it 'invalidates an entry with both new post content and a forum topic ID'

  it 'invalidates an entry with an invalid forum topic ID' do
    @page.tab_links[4].click
    @page.forum_tab.forum_topic_id.set '999'
    @page.forum_tab.forum_topic_id.trigger 'blur'
    @page.wait_for_error_message_count(1)
    should_have_form_errors(@page)
    should_have_error_text(
      @page.forum_tab.forum_topic_id,
      'There is no forum topic with that ID.'
    )

    @page.forum_tab.forum_topic_id.set ''
    @page.forum_tab.forum_topic_id.trigger 'blur'
    @page.wait_for_error_message_count(0)
    should_have_no_form_errors(@page)
    should_have_no_error_text(@page.forum_tab.forum_topic_id)
  end
end
