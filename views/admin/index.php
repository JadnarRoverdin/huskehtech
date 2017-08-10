<h2>Choose an action</h2>
<div><?php echo $message; ?></div>
<div>

  <table>
    <tr>
      <td>
        <li><a href = '?controller=admin&action=addPost'>Add A Post</a></li>
        <li><a href = '?controller=admin&action=deletePosts'>Delete Posts</a></li>
        <li><a href = '?controller=admin&action=addTag'>Add A Tag</a></li>
      </td>
      <td>
        <li><a href = '?controller=evaluation&action=addCriteria'>Add Criteria</a></li>
        <li><a href = '?controller=evaluation&action=addCriteriaSet'>Create a Criteria Set</a></li>
      </td>
      <td>
        <li><a href = '?controller=user&action=addUser'>Register User</a></li>
      </td>
    </tr>
  </table>
</div>
