Hello {{$user->name}},<br />

<p>Your sites have been updated. You now have access to:</p>
<ul>
    @foreach($sites as $site)
        <li>{{$site->name}}</li>
    @endforeach
</ul>

<p>You can visit to the Bee Hub, by clicking on this link: <a href="http://cms.brightonacademiestrust.org.uk/" target="_blank">http://cms.brightonacademiestrust.org.uk/</a></p>

Best wishes,<br />
Webteam
